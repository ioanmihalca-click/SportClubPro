<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Rezultate Eveniment</title>
   <style>
       body { font-family: DejaVu Sans, sans-serif; }
       .header { text-align: center; margin-bottom: 30px; }
       table { width: 100%; border-collapse: collapse; }
       th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
       th { background-color: #f2f2f2; }
       .footer { margin-top: 30px; font-size: 12px; text-align: right; }
       .event-details { margin-bottom: 20px; }
   </style>
</head>
<body>
   <div class="header">
       <h1>{{ $clubName }}</h1>
       <h2>Rezultate Eveniment</h2>
   </div>

   <div class="event-details">
       <p><strong>Eveniment:</strong> {{ $event->name }}</p>
       <p><strong>Data:</strong> {{ $event->date->format('d.m.Y') }}</p>
       <p><strong>Tip:</strong> {{ $event->type }}</p>
   </div>

   <table>
       <thead>
           <tr>
               <th>Participant</th>
               <th>Rezultat</th>
           </tr>
       </thead>
       <tbody>
           @foreach($event->participants as $participant)
           <tr>
               <td>{{ $participant->name }}</td>
               <td>{{ $participant->pivot->result ?? '-' }}</td>
           </tr>
           @endforeach
       </tbody>
   </table>

   <div class="footer">
       Generat la: {{ $generatedAt->format('d.m.Y H:i') }}
   </div>
</body>
</html>