<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollments Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="index.php">
            <i class="bi bi-mortarboard-fill"></i>
            Student Management System
        </a>
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=students">
                        <i class="bi bi-people me-1"></i>Students
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=courses">
                        <i class="bi bi-journal-bookmark me-1"></i>Courses
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=departments">
                        <i class="bi bi-building me-1"></i>Departments
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="index.php?page=enrollments">
                        <i class="bi bi-clipboard-check me-1"></i>Enrollments
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container pb-5">

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h2 class="mb-1">Course Enrollments</h2>
            <p class="text-muted small mb-0">Track which students are enrolled in which courses.</p>
        </div>
        <a href="index.php?page=enrollments&action=create" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus me-1"></i>Enroll Student in Course
        </a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="enrollmentsTable" class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Student Name</th>
                        <th>Course Name</th>
                        <th>Course Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($enrollments)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="bi bi-clipboard-x d-block fs-2 text-muted mb-2"></i>
                            <span class="text-muted">No enrollments found.</span>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($enrollments as $enrollment): ?>
                        <tr>
                            <td><?= htmlspecialchars($enrollment['student_name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($enrollment['course_name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <span class="badge bg-secondary">
                                    <?= htmlspecialchars($enrollment['code'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?page=enrollments&action=drop&student_id=<?= (int) $enrollment['student_id'] ?>&course_id=<?= (int) $enrollment['course_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to drop this course?')">
                                    <i class="bi bi-x-circle"></i> Drop
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

<script>
    $(function () {
        $('#enrollmentsTable').DataTable({
            paging: true,
            searching: true,
            ordering: false,
            autoWidth: false,
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries"
            }
        });
        $('#enrollmentsTable').wrap('<div class="table-responsive"></div>');
    });
</script>

</body>
</html>