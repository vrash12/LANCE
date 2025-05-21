#flask-analytics/app/services/arima_model.py
from .arima_model import load_arima_model, predict_arima
from .lstm_model import load_lstm_model, predict_lstm

def run_ensemble(date_from, date_to):
    """
    8.1 & 8.2: 
    - load ARIMA & LSTM,
    - fetch historical data,
    - combine forecasts (e.g. average),
    and return a dict with metrics+forecast arrays.
    """
    # TODO: implement data fetch, model load, prediction
    return {
        "historical_mean": 50.0,
        "arima_forecast": [52, 55, 53],
        "lstm_forecast":  [51, 54, 56],
        "ensemble":       [51.5, 54.5, 54.5],
    }
