<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Raport Financiar</title>
   <style>
       body { font-family: DejaVu Sans, sans-serif; }
       .header { text-align: center; margin-bottom: 30px; }
       table { width: 100%; border-collapse: collapse; }
       th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
       th { background-color: #f2f2f2; }
       .footer { margin-top: 30px; font-size: 12px; text-align: right; }
       .total { margin-top: 20px; text-align: right; font-weight: bold; }
   </style>
</head>
<body>
   <div class="header">
       <h1>{{ $clubName }}</h1>
       <h2>Raport Financiar - {{ $month }}</h2>
   </div>

   <table>
       <thead>
           <tr>
               <th>Data</th>
               <th>Membru</th>
               <th>Tip Cotizație</th>
               <th>Sumă</th>
           </tr>
       </thead>
       <tbody>
           @foreach($payments as $payment)
           <tr>
               <td>{{ $payment->payment_date->format('d.m.Y') }}</td>
               <td>{{ $payment->member->name }}</td>
               <td>{{ $payment->feeType->name }}</td>
               <td>{{ number_format($payment->amount, 2) }} RON</td>
           </tr>
           @endforeach
       </tbody>
   </table>

   <div class="total">
       Total încasat: {{ number_format($totalAmount, 2) }} RON
   </div>

   <div class="footer">
       Generat la: {{ $generatedAt->format('d.m.Y H:i') }}
   </div>
</body>
</html>