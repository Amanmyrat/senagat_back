<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: DejaVu Sans, Arial, sans-serif;
        font-size: 13px;
        color: #1a1a1a;
        background: #fff;
        padding: 30px;
    }

    h1 {
        font-size: 20px;
        margin-bottom: 24px;
        border-bottom: 2px solid #3b82f6;
        padding-bottom: 10px;
        color: #1d4ed8;
    }

    h2 {
        font-size: 15px;
        margin: 20px 0 10px;
        color: #374151;
        border-left: 4px solid #3b82f6;
        padding-left: 10px;
    }

    .section {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 20px;
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .field { margin-bottom: 8px; }

    .field label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .field span {
        display: block;
        font-size: 13px;
        color: #111827;
        padding: 6px 10px;
        background: #fff;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        min-height: 32px;
    }

    .badge {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success { background: #dcfce7; color: #166534; }
    .badge-danger  { background: #fee2e2; color: #991b1b; }
    .badge-warning { background: #fef9c3; color: #854d0e; }

    .checkbox-val {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .checkbox-yes { background: #dcfce7; color: #166534; }
    .checkbox-no  { background: #fee2e2; color: #991b1b; }

    .passport-img {
        max-width: 100%;
        max-height: 400px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        margin-top: 8px;
    }

    .full-width { grid-column: 1 / -1; }

    @media print {
        body { padding: 10px; }
        .no-print { display: none; }
    }
</style>
