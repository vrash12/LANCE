from flask import Blueprint, request, jsonify
from ...services.ensemble import run_ensemble

trends_bp = Blueprint("trends", __name__)

@trends_bp.route("/analyse", methods=["POST"])
def analyse():
    """8.1 Request Trend Insight"""
    data = request.json or {}
    date_from = data.get("from")
    date_to   = data.get("to")
    result = run_ensemble(date_from, date_to)
    return jsonify(result), 202

@trends_bp.route("/result", methods=["GET"])
def result():
    """8.2 View Patient Trend Analysis"""
    date_from = request.args.get("from")
    date_to   = request.args.get("to")
    # For now just re-run
    result = run_ensemble(date_from, date_to)
    return jsonify(result)

@trends_bp.route("/chart", methods=["GET"])
def chart():
    """8.3 Filter Trends & optionally return chart payload"""
    # You could produce a Base64 PNG or JSON spec here
    return jsonify({"message": "chart endpoint placeholder"})
