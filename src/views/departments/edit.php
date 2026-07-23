<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="index.php">
                <i class="bi bi-mortarboard-fill"></i>
                Student Management System
            </a>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-dark py-3">
                        <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Department</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="index.php?page=departments&action=update" method="POST">
                            <input type="hidden" name="id" value="<?= (int) $department['id'] ?>">
                            
                            <div class="mb-4">
                                <label for="name" class="form-label">Department Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($department['name'], ENT_QUOTES, 'UTF-8') ?>" required>
                            </div>

                            <div class="d-flex flex-column-reverse flex-sm-row justify-content-between gap-2">
                                <a href="index.php?page=departments" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Update Department
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>