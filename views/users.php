<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Users</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/logout" class="btn btn-danger">Logout</a>
    <?php else: ?>
        <a href="/login" class="btn btn-primary">Login</a>
    <?php endif; ?>
    <br><br>
    <?php if ($isLogged): ?>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['created_at'] ?></td>
                <td>
                    <button class="btn btn-danger delete-user-btn" data-id="<?= $user['id'] ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <button class="btn btn-primary create-user-btn">Create User</button>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.delete-user-btn').click(function() {
            if (confirm('Are you sure you want to delete this user?')) {
                $.post('/delete', {id: $(this).data('id')}, function() {
                    location.reload();
                });
            }
        });

        $('.create-user-btn').click(function() {
            $.get('/create', function(data) {
                $('body').append(data);
            });
        });
    });
</script>
</body>
</html>
