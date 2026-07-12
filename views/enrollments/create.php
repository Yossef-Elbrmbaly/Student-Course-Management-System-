<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll Student</title>
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
                    <h4 class="mb-0"><i class="bi bi-person-plus me-2"></i>Enroll Student in Course</h4>
                </div>
                <div class="card-body p-4">
                    <form action="index.php?page=enrollments&action=store" method="POST">
                        <div class="mb-3">
                            <label for="student_id" class="form-label">
                                Student
                            </label>
                            <select
                                id="student_id"
                                name="student_id"
                                class="form-select"
                                required>
                                <option value="">Select Student</option>
                                <?php foreach ($students as $student): ?>
                                    <option value="<?= $student['id'] ?>">
                                        <?= ($student['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="course_id" class="form-label">
                                Course
                            </label>
                            <select
                                id="course_id"
                                name="course_id"
                                class="form-select"
                                required>
                                <option value="">Select Course</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>">
                                        <?= ($course['name']) ?>
                                        (<?= ($course['code']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-flex flex-column-reverse flex-sm-row justify-content-between gap-2">
                            <a href="index.php?page=enrollments" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </a>
                            <button type="submit"
                                    class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i>Enroll
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