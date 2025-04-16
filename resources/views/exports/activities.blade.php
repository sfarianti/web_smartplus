<table>
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Tanggal</th>
            <th>Kursus</th>
            <th>Aktivitas</th>
            <th>Penguasaan Siswa</th>
            <th>Tentor</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activities as $activity)
        <tr>
            <td>{{ $activity['id'] }}</td>
            <td>{{ $activity['date'] }}</td>
            <td>{{ $activity['course'] }}</td>
            <td>{{ $activity['activity'] }}</td>
            <td>{{ $activity['feedback'] }}</td>
            <td>{{ $activity['tutor'] }}</td>
            <td>{{ $activity['harga'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
