<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Raport Prezențe</title>
   <style>
       body { font-family: DejaVu Sans, sans-serif; }
       .header { text-align: center; margin-bottom: 30px; }
       table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
       th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
       th { background-color: #f2f2f2; }
       .footer { margin-top: 30px; font-size: 12px; text-align: right; }
       .date-header { margin-top: 20px; margin-bottom: 10px; font-weight: bold; }
   </style>
</head>
<body>
   <div class="header">
       <h1>{{ $clubName }}</h1>
       <h2>Raport Prezențe</h2>
       <p>Perioada: {{ Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - {{ Carbon\Carbon::parse($endDate)->format('d.m.Y') }}</p>
   </div>

   @foreach($attendances as $date => $dayAttendances)
       <div class="date-header">
           {{ Carbon\Carbon::parse($date)->format('d.m.Y') }}
       </div>
       <table>
           <thead>
               <tr>
                   <th>Membru</th>
                   <th>Grupă</th>
               </tr>
           </thead>
           <tbody>
               @foreach($dayAttendances as $attendance)
               <tr>
                   <td>{{ $attendance->member->name }}</td>
                   <td>{{ $attendance->group->name }}</td>
               </tr>
               @endforeach
           </tbody>
       </table>
   @endforeach

   <div class="footer">
       Generat la: {{ $generatedAt->format('d.m.Y H:i') }}
   </div>
</body>
</html>