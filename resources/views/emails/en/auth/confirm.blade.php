Welcome! {{ $user->name }}.
Open URl for Check to Complete Register : {{ route('users.confirm', $user->confirm_code) }}