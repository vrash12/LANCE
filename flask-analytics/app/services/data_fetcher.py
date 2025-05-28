# flask-analytics/app/services/data_fetcher.py

import os
import mysql.connector
from datetime import datetime

def get_db_connection():
    return mysql.connector.connect(
        host     = os.getenv("DB_HOST", "localhost"),
        user     = os.getenv("DB_USER", "your_user"),
        password = os.getenv("DB_PASS", "your_pass"),
        database = os.getenv("DB_NAME", "your_db"),
        charset  = "utf8mb4"
    )

def fetch_patient_visit_counts(date_from=None, date_to=None):
    """
    Returns a list of dicts: [{"date": "YYYY-MM-DD", "count": 42}, …]
    based on served tokens per day.
    """
    conn = get_db_connection()
    cur  = conn.cursor(dictionary=True)

    # default to last 30 days if none supplied
    if not date_to:
        date_to = datetime.today().strftime("%Y-%m-%d")
    if not date_from:
        # 30 days before
        date_from = (datetime.today() - 
                     timedelta(days=30)).strftime("%Y-%m-%d")

    cur.execute("""
        SELECT 
          DATE(served_at) AS date,
          COUNT(*)         AS count
        FROM tokens
        WHERE served_at IS NOT NULL
          AND DATE(served_at) BETWEEN %s AND %s
        GROUP BY DATE(served_at)
        ORDER BY DATE(served_at)
    """, (date_from, date_to))

    rows = cur.fetchall()
    cur.close()
    conn.close()
    return rows
