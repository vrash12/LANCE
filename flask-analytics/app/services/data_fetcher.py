
# flask-analytics/app/services/data_fetcher.py

from datetime import datetime
from typing import List, Dict, Optional
import pandas as pd
from .models import PatientVisit, Token
from . import db


def fetch_patient_visits(date_from: Optional[datetime] = None,
                         date_to:   Optional[datetime] = None) -> List[Dict]:
    """
    Query PatientVisit records between date_from and date_to.

    Returns list of dicts: { 'visited_at': ..., 'notes': ... }
    """
    q = db.session.query(PatientVisit)
    if date_from:
        q = q.filter(PatientVisit.visited_at >= date_from)
    if date_to:
        q = q.filter(PatientVisit.visited_at <= date_to)
    visits = q.all()
    return [{
        'visited_at': v.visited_at,
        'notes':      v.notes,
    } for v in visits]


def fetch_patient_visit_counts(date_from: Optional[datetime] = None,
                               date_to:   Optional[datetime] = None) -> List[Dict]:
    """
    Returns daily visit counts: [{ 'date': date, 'count': n }, ...]
    """
    records = fetch_patient_visits(date_from, date_to)
    if not records:
        return []
    df = pd.DataFrame(records)
    df['date'] = pd.to_datetime(df['visited_at']).dt.date
    counts = df.groupby('date').size().reset_index(name='count')
    return counts.to_dict('records')


def fetch_pending_tokens(date_from: Optional[datetime] = None,
                         date_to:   Optional[datetime] = None) -> int:
    """
    Count tokens created but not completed in the given range.
    """
    q = db.session.query(Token)
    if date_from:
        q = q.filter(Token.created_at >= date_from)
    if date_to:
        q = q.filter(Token.created_at <= date_to)
    return q.filter(Token.completed_at.is_(None)).count()


def fetch_completed_tokens(date_from: Optional[datetime] = None,
                           date_to:   Optional[datetime] = None) -> int:
    """
    Count tokens marked completed in the given range.
    """
    q = db.session.query(Token)
    if date_from:
        q = q.filter(Token.completed_at >= date_from)
    if date_to:
        q = q.filter(Token.completed_at <= date_to)
    return q.filter(Token.completed_at.isnot(None)).count()
