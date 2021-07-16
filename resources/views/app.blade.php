<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    {{ vite('dist/app.js') }}
</head>
<body>
	<div id="app"></div>

	<script>
		const config = {
			url 	: "{{ url('') }}",
			name	: "{{ env('APP_NAME') }}",
		}
	</script>
</body>
</html>
