<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Car</title>
</head>
<body>
    <div>
        <div>
            {{-- @if(\File::exists('storage/uploads/logo/'.$user->logo)) --}}
                <img src="{{ asset('storage/uploads/logo/'.$user->logo) }}" alt="" style="width:280px" />
            {{-- @else
                <img src="{{ asset('storage/uploads/logo/'.$company->logo) }}" alt="" style="width:280px" />
            @endif --}}
        </div>
    </div>
</body>
</html>
