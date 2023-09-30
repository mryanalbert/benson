<?php
session_start();
require_once './query.php';
$query = new Query();

// Login Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'login') {
  $username = $query->testInput($_POST['username']);
  $password = $query->testInput($_POST['password']);

  $admin = $query->fetchAdminUser($username);
  
  if ($admin) {
    if ($admin['password'] == sha1($password)) {
      $_SESSION['admin_system'] = $username;
      echo json_encode($admin);
    }
  } else {
    echo false;
  }
}

// Add faculty Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'addFaculty') {
  $fname = $query->testInput($_POST['fname']);
  $mname = $query->testInput($_POST['mname']);
  $lname = $query->testInput($_POST['lname']);
  $dep = $query->testInput($_POST['dep']);
  $gen = $query->testInput($_POST['gen']);
  $img = $_FILES['img'];
  $imgName = $_FILES['img']['name'];

  if (isset($imgName) && $imgName) {
    move_uploaded_file($img['tmp_name'], "./uploads/img/{$imgName}");
    echo $query->addFaculty($fname, $mname, $lname, $dep, $gen, $imgName);
  } else {
    echo $query->addFaculty($fname, $mname, $lname, $dep, $gen, "");
  }
}

// Fetch Faculties
if (isset($_POST['action']) && $_POST['action'] == 'fetchFaculties') {
  echo json_encode($query->fetchFaculties());
}

// View Faculty
if (isset($_POST['action']) && $_POST['action'] == 'viewFaculty') {
  $id = $query->testInput($_POST['id']);
  echo json_encode($query->fetchFaculty($id));
}

// Edit Faculty
if (isset($_POST['action']) && $_POST['action'] == 'editFaculty') {
  $id = $query->testInput($_POST['id']);
  echo json_encode($query->fetchFaculty($id));
}

// Add Department
if (isset($_POST['action']) && $_POST['action'] == 'addDep') {
  $dep_name = $query->testInput($_POST['dep-name']);
  $dep_desc = $query->testInput($_POST['dep-desc']);

  echo json_encode($query->addDep($dep_name, $dep_desc));
}

// Fetch Departments
if (isset($_POST['action']) && $_POST['action'] == 'fetchDeps') {
  echo json_encode($query->fetchDeps());
}

// Fetch Department
if (isset($_POST['action']) && $_POST['action'] == 'fetchDep') {
  $id = $query->testInput($_POST['id']);
  echo json_encode($query->fetchDep($id));
}

// Edit Department
if (isset($_POST['action']) && $_POST['action'] == 'editDep') {
  $id = $query->testInput($_POST['id']);
  echo json_encode($query->fetchDep($id));
}

// Update Department
if (isset($_POST['action']) && $_POST['action'] == 'updateDep') {
  $id = $query->testInput($_POST['edit-dep-id']);
  $dep = $query->testInput($_POST['edit-dep-name']);
  $desc = $query->testInput($_POST['edit-dep-desc']);

  echo $query->updateDep($id, $dep, $desc);
}

// Delete Department
if (isset($_POST['action']) && $_POST['action'] == 'delDep') {
  $id = $query->testInput($_POST['id']);
  if (sizeof($query->depExistsInFaculty($id)) > 0) {
    echo 'used';
  } 
  else {
    echo $query->delDep($id);
  }
}

// Delete Faculty
if (isset($_POST['action']) && $_POST['action'] == 'delFaculty') {
  $id = $query->testInput($_POST['id']);

  if (sizeof($query->facultyUsedInSchedules($id)) > 0) {
    echo 'used';
  } else {
    echo $query->delFaculty($id);
  }
}

// Update Faculty
if (isset($_POST['action']) && $_POST['action'] == 'updateFaculty') {
  $id = $query->testInput($_POST['edit-id']);
  $fname = $query->testInput($_POST['edit-fname']);
  $mname = $query->testInput($_POST['edit-mname']);
  $lname = $query->testInput($_POST['edit-lname']);
  $dep = $query->testInput($_POST['edit-dep']);
  $gen = $query->testInput($_POST['edit-gen']);
  $img = $_FILES['edit-img'];
  $imgName = $_FILES['edit-img']['name'];

  if (isset($imgName) && $imgName) {
    move_uploaded_file($img['tmp_name'], "./uploads/img/{$imgName}");
    echo $query->updateFacultyWithImg($id, $fname, $mname, $lname, $dep, $gen, $imgName);
  } else {
    echo $query->updateFacultyWithoutImg($id, $fname, $mname, $lname, $dep, $gen);
  }
}

// Add room
if (isset($_POST['action']) && $_POST['action'] == 'addRoom') {
  $rname = $query->testInput($_POST['room-name']);
  $rbldg = $query->testInput($_POST['room-bldg']);

  echo $query->addRoom($rname, $rbldg);
}

// Fetch rooms
if (isset($_POST['action']) && $_POST['action'] == 'fetchRooms') {
  echo json_encode($query->fetchRooms());
}

// Fetch a room
if (isset($_POST['action']) && $_POST['action'] == 'fetchRoom') {
  $id = $query->testInput($_POST['id']);
  echo json_encode($query->fetchRoom($id));
}

// Update a room
if (isset($_POST['action']) && $_POST['action'] == 'updateRoom') {
  $id = $query->testInput($_POST['edit-room-id']);
  $room = $query->testInput($_POST['edit-room-name']);
  $bldg = $query->testInput($_POST['edit-room-bldg']);
  echo $query->updateRoom($id, $room, $bldg);
}

// View Room
if (isset($_POST['action']) && $_POST['action'] == 'viewRoom') {
  $id = $query->testInput($_POST['id']);
  echo json_encode($query->fetchRoom($id));
}

// Delete Room
if (isset($_POST['action']) && $_POST['action'] == 'delRoom') {
  $id = $query->testInput($_POST['id']);

  if ($query->roomUsedInSchedules($id)) {
    echo 'used';
  } else {
    echo $query->delRoom($id);
  }
}

// Add subject
if (isset($_POST['action']) && $_POST['action'] == 'addSubject') {
  $code = $query->testInput($_POST['sub-code']);
  $title = $query->testInput($_POST['sub-title']);
  $desc = $query->testInput($_POST['sub-desc']);

  if (sizeof($query->codeExistsInSubj($code)) > 0) {
    echo 'exists';
  } else {
    echo $query->addSubject($code, $title, $desc);
  }
}

// Fetch subjects
if (isset($_POST['action']) && $_POST['action'] == 'fetchSubjects') {
  echo json_encode($query->fetchSubjects());
}

// Edit subjects
if (isset($_POST['action']) && $_POST['action'] == 'editSubject') {
  $id = $query->testInput($_POST['id']);
  echo json_encode($query->fetchSubject($id));
}

// View Room
if (isset($_POST['action']) && $_POST['action'] == 'viewSubject') {
  $id = $query->testInput($_POST['id']);
  echo json_encode($query->fetchSubject($id));
}

// Delete Room
if (isset($_POST['action']) && $_POST['action'] == 'delSubject') {
  $id = $query->testInput($_POST['id']);

  if ($query->subjectUsedInSchedules($id)) {
    echo 'used';
  } else {
    echo $query->delSubject($id);
  }
}

// Update Subject
if (isset($_POST['action']) && $_POST['action'] == 'updateSubject') {
  $id = $query->testInput($_POST['edit-sub-id']);
  $code = $query->testInput($_POST['edit-sub-code']);
  $title = $query->testInput($_POST['edit-sub-title']);
  $desc = $query->testInput($_POST['edit-sub-desc']);
  echo $query->updateSubject($id, $code, $title, $desc);
}