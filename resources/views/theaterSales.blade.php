<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theater Sales</title>
</head>
<body>
    <div style="text-align: center">
        <h1>Hello and welcome to the Northwest Theater sales tracking system!</h1>
        <h2>Please enter a date from 11-8-2024 to 11-10-2024 to check which theater in the Northwest group had the highest sales</h2>

        <form action="/theater-sales" method="POST">
            @csrf
            <label for="sales_date">Sales Date (MM-DD-YYYY):</label>
            <input type="text" id="sales_date" name="sales_date" value="{{ old('sales_date') }}" required>
            @error('sales_date')
                <div style="color: red;">{{ $message }}</div>
            @enderror
            <button type="submit">Submit</button>
        </form>

        @if ($result)
            <h2>Top Theater by Sales on {{ \Carbon\Carbon::parse($result->sales_date)->format('m-d-Y') }}</h2>
            <p>Theater: {{ $result->theater_name }}</p>
            <p>Total Sales: ${{ number_format($result->total_sales, 2) }}</p>
        @elseif(request()->isMethod('post'))
            <p>No data found for the given date.</p>
        @endif
    </div>
</body>
</html>
