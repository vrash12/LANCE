# flask-analytics/app/services/arima_model.py

import joblib
import os
from datetime import datetime
import pandas as pd
import numpy as np
from statsmodels.tsa.arima.model import ARIMAResults
from tensorflow.keras.models import load_model
from .data_fetcher import fetch_patient_visit_counts, fetch_pending_tokens, fetch_completed_tokens


def load_arima_model(path: str) -> ARIMAResults:
    """
    Load a persisted ARIMAResults object from disk using joblib.
    """
    return joblib.load(path)


def predict_arima(model: ARIMAResults, history: np.ndarray, periods: int) -> list:
    """
    Forecast the next `periods` points using a fitted ARIMA model.

    Parameters:
      - model: fitted ARIMAResults
      - history: 1D array of historical values
      - periods: number of future points to forecast

    Returns:
      - List of forecasted values
    """
    forecast = model.forecast(steps=periods)
    return forecast.tolist()


def load_lstm_model(path: str):
    """
    Load a saved Keras/TensorFlow LSTM model from disk.
    """
    return load_model(path)


def predict_lstm(model, data: np.ndarray, periods: int, scaler=None) -> list:
    """
    Given a 1D data array, forecast next `periods` points using an LSTM.

    If a scaler is provided, applies inverse_transform.
    """
    preds = []
    seq = data[-model.input_shape[1]:].reshape(1, -1, 1)
    for _ in range(periods):
        yhat = model.predict(seq)
        if scaler:
            yhat = scaler.inverse_transform(yhat)
        val = float(yhat[0, 0])
        preds.append(val)
        seq = np.append(seq[:, 1:, :], [[[val]]], axis=1)
    return preds


def run_ensemble(date_from=None, date_to=None,
                 arima_model_path="models/arima.pkl",
                 lstm_model_path="models/lstm.h5",
                 periods: int = 3) -> dict:
    """
    Load models, fetch historical counts, run ARIMA + LSTM forecasts, and average.

    Returns a dict with:
      - historical_mean
      - arima_forecast
      - lstm_forecast
      - ensemble (averaged)
    """
    # fetch daily visit counts
    records = fetch_patient_visit_counts(date_from, date_to)
    dates = [r['date'] for r in records]
    counts = np.array([r['count'] for r in records])

    # load and predict
    arima = load_arima_model(arima_model_path)
    arima_fc = predict_arima(arima, counts, periods)

    lstm = load_lstm_model(lstm_model_path)
    lstm_fc = predict_lstm(lstm, counts, periods)

    ensemble = [(a + l) / 2 for a, l in zip(arima_fc, lstm_fc)]

    return {
        "historical_mean": float(counts.mean()),
        "arima_forecast": arima_fc,
        "lstm_forecast": lstm_fc,
        "ensemble": ensemble,
    }


def build_report(date_from=None, date_to=None, force_recalc=False, export: str = None):
    """
    Compile KPIs and return either metrics dict or file path if exporting.

    If export is "pdf" or "xlsx", writes file to disk and returns path.
    """
    # fetch basic metrics
    visits = fetch_patient_visit_counts(date_from, date_to)
    total_visits = sum(r['count'] for r in visits)
    pending = fetch_pending_tokens(date_from, date_to)
    complete = fetch_completed_tokens(date_from, date_to)

    metrics = {
        "total_visits": total_visits,
        "pending_tokens": pending,
        "complete_tokens": complete,
    }

    # ensemble forecasts
    ensemble_results = run_ensemble(date_from, date_to)
    metrics.update(ensemble_results)

    if export in ("pdf", "xlsx"):
        df = pd.DataFrame([metrics])
        filename = f"reports/report_{date_from}_{date_to}.{export}"
        os.makedirs(os.path.dirname(filename), exist_ok=True)
        if export == "pdf":
            # simple PDF via DataFrame.to_html -> wkhtmltopdf or reportlab (placeholder)
            df.to_excel(filename.replace('.pdf', '.xlsx'), index=False)
            # TODO: convert to PDF
        else:
            df.to_excel(filename, index=False)
        return filename

    return metrics
