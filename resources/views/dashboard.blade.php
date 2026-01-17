<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: sans-serif; margin: 20px; background-color: white; color: #333; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .section { margin-top: 30px; border: 1px solid #ddd; padding: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f8f8; }
        form { margin-bottom: 0; }
        input, select { padding: 8px; margin: 5px; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 8px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; }
        .btn-red { background: #dc3545; }
        .alert { padding: 10px; margin-bottom: 10px; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dashboard</h1>
        <div>
            Welcome, <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->role }}) | 
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none; border:none; color:blue; cursor:pointer; text-decoration:underline;">Logout</button>
            </form>
        </div>
    </div>

    @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert error">{{ session('error') }}</div> @endif

    <div style="display: flex; gap: 20px;">
        @if(strtolower(auth()->user()->role) !== 'superadmin')
        <div class="section" style="flex: 1;">
            <h3>Create Short URL</h3>
            <form action="{{ route('shorten') }}" method="POST">
                @csrf
                <input type="url" name="original_url" placeholder="Paste URL here..." required style="width: 70%;">
                <button type="submit" class="btn">Shorten</button>
            </form>
        </div>
        @endif

        @if(in_array(strtolower(auth()->user()->role), ['superadmin', 'admin']))
        <div class="section" style="flex: 1;">
            <h3>Invite User</h3>
            <form action="{{ route('invite') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required><br>
                <select name="role" required>
                    <option value="Admin">Admin</option>
                    <option value="Member">Member</option>
                </select>
                @if(strtolower(auth()->user()->role) === 'superadmin')
                    <input type="text" name="company_name" placeholder="Company Name" required>
                @endif
                <button type="submit" class="btn">Invite</button>
            </form>
        </div>
        @endif
    </div>

    <div class="section">
        <h3>Shared Links</h3>
        <table>
            <thead>
                <tr>
                    <th>Original URL</th>
                    <th>Short URL</th>
                    <th>By</th>
                    @if(strtolower(auth()->user()->role) === 'superadmin') <th>Company</th> @endif
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shortUrls as $url)
                <tr>
                    <td>{{ $url->original_url }}</td>
                    <td><a href="{{ route('short_url.resolve', $url->short_code) }}" target="_blank">{{ url('/s/'.$url->short_code) }}</a></td>
                    <td>{{ $url->user->name }}</td>
                    @if(strtolower(auth()->user()->role) === 'superadmin') <td>{{ $url->company->name ?? '-' }}</td> @endif
                    <td>{{ $url->created_at->format('d-M-Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5">No links found.</td></tr>
                @endforelse
            </tbody>
        </table>                                                                                                                                                                                                                                
    </div>
</body>
</html>
