<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Department</title>

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

                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0"><i class="bi bi-building-add me-2"></i>Add New Department</h4>
                    </div>

                    <div class="card-body p-4">

                        <form action="index.php?page=departments&action=store" method="POST">

                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    Department Name
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control"
                                    required
                                >
                            </div>

                            <div class="d-flex flex-column-reverse flex-sm-row justify-content-between gap-2">

                                <a href="index.php?page=departments" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Cancel
                                </a>

                                <button type="submit"
                                        class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i>Save Department
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