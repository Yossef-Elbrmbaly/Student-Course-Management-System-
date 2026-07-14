<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - <?= htmlspecialchars($student['name']) ?></title>
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?page=students">
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
                        <a class="nav-link" href="index.php?page=enrollments">
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
                <a href="index.php?page=students" class="text-decoration-none small text-muted d-inline-flex align-items-center mb-2">
                    <i class="bi bi-arrow-left me-1"></i> Back to Students List
                </a>
                <h2 class="mb-0">Student Profile</h2>
            </div>
            <a href="index.php?page=students&action=edit&id=<?= $student['id'] ?>" class="btn btn-warning shadow-sm">
                <i class="bi bi-pencil-square me-1"></i>Edit Student
            </a>
        </div>

        <div class="row g-4">

            <!-- Student info card -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4 text-center">
                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary"
                            style="width:88px;height:88px;font-size:2rem;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h4 class="mb-1"><?= htmlspecialchars($student['name']) ?></h4>
                        <p class="text-muted small mb-3">Student #<?= $student['id'] ?></p>

                        <ul class="list-group list-group-flush text-start">
                            <li class="list-group-item d-flex align-items-center gap-2 px-0">
                                <i class="bi bi-envelope text-muted"></i>
                                <span><?= htmlspecialchars($student['email']) ?></span>
                            </li>
                            <li class="list-group-item d-flex align-items-center gap-2 px-0">
                                <i class="bi bi-telephone text-muted"></i>
                                <span><?= !empty($student['phone']) ? htmlspecialchars($student['phone']) : 'Not provided' ?></span>
                            </li>
                            <li class="list-group-item d-flex align-items-center gap-2 px-0">
                                <i class="bi bi-building text-muted"></i>
                                <span>
                                    <?php if ($department): ?>
                                        <?= htmlspecialchars($department['name']) ?>
                                    <?php else: ?>
                                        <span class="text-muted">Not Assigned</span>
                                    <?php endif; ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Enrolled courses card -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-journal-bookmark me-2"></i>Enrolled Courses</h5>
                        <span class="badge bg-primary rounded-pill"><?= count($courses) ?></span>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($courses)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Code</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($courses as $course): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($course['name']) ?></td>
                                                <td>
                                                    <span class="badge bg-secondary"><?= htmlspecialchars($course['code']) ?></span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="index.php?page=enrollments&action=drop&student_id=<?= $student['id'] ?>&course_id=<?= $course['id'] ?>"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to drop this course?')">
                                                        <i class="bi bi-x-circle"></i> Drop
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-journal-x d-block fs-2 text-muted mb-2"></i>
                                <p class="text-muted mb-3">This student isn't enrolled in any courses yet.</p>
                                <a href="index.php?page=enrollments&action=create" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-circle me-1"></i>Enroll in a Course
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>