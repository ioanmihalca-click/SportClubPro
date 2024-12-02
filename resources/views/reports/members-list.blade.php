<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista Membri</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 30px; font-size: 12px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $clubName }}</h1>
        <h2>Lista Membri</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nume</th>
                <th>Grupa</th>
                <th>Tip Cotizație</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->group?->name ?? '-' }}</td>
                <td>{{ $member->feeType?->name ?? '-' }}</td>
                <td>{{ $member->active ? 'Activ' : 'Inactiv' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generat la: {{ $generatedAt->format('d.m.Y H:i') }}
    </div>
</body>
</html>
