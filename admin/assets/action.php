<?php
session_start();

require '../vendor/autoload.php';
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

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

  $uniqid = uniqid();

  $writer = new PngWriter();

  $qrcode = QrCode::create($uniqid)
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

  $result = $writer->write($qrcode);

  header('Content-Type: '.$result->getMimeType());
  $qrcode_img = time() . '.png';
  // Save it to a file
  $result->saveToFile(__DIR__."/img/". $qrcode_img);

  if (isset($imgName) && $imgName) {
    move_uploaded_file($img['tmp_name'], "./uploads/img/{$imgName}");
    echo $query->addFaculty($fname, $mname, $lname, $dep, $gen, $imgName, $uniqid, $qrcode_img);
  } else {
    echo $query->addFaculty($fname, $mname, $lname, $dep, $gen, "", $uniqid, $qrcode_img);
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

// Add Schedule
if (isset($_POST['action']) && $_POST['action'] == 'addSchedule') {

  $sched_ay = $query->testInput($_POST['sched-ay']);
  $sched_sem = $query->testInput($_POST['sched-sem']);

  $sched_days = '';
  if (isset($_POST['sched-days'])) {
    $sched_days = $_POST['sched-days'];
  }

  $start_time = $query->testInput($_POST['start-time']);
  $end_time = $query->testInput($_POST['end-time']);
  $sched_sub = $query->testInput($_POST['sched-sub']);
  $sched_room = $query->testInput($_POST['sched-room']);
  $sched_fac = $query->testInput($_POST['sched-fac']);

  if ($start_time >= $end_time) {
    echo 'time error';
    return;
  }

  if (empty($sched_ay) || empty($sched_sem) || empty($sched_days) || empty($start_time) || empty($end_time) || empty($sched_sub) || empty($sched_room) || empty($sched_fac)) {
    echo 'empty';
    return;
  }

  $schedsWithoutTime = $query->conflictSchedules($sched_ay, $sched_sem, $sched_days, $sched_room);

  $conflictTimes = [];
  foreach ($schedsWithoutTime as $schedWithoutTime) {
    if (strtotime($start_time) >= strtotime($schedWithoutTime['sch_time_from'])) {
      if (strtotime($start_time) < strtotime($schedWithoutTime['sch_time_to'])) {
        $schedWithoutTime['sch_time_from'] = date("h:ia", strtotime($schedWithoutTime['sch_time_from']));
        $schedWithoutTime['sch_time_to'] = date("h:ia", strtotime($schedWithoutTime['sch_time_to']));
        array_push($conflictTimes, $schedWithoutTime);
      }
    } 
    // else if (strtotime($start_time) < strtotime($schedWithoutTime['sch_time_from']) && strtotime($schedWithoutTime['sch_time_from']) >= strtotime($end_time)) {
    //   continue;
    // }
    else if (strtotime($start_time) < strtotime($schedWithoutTime['sch_time_from']) && strtotime($schedWithoutTime['sch_time_from']) < strtotime($end_time)) {
      array_push($conflictTimes, $schedWithoutTime);
    }
  }

  if (sizeof($conflictTimes) > 0) {
    echo json_encode($conflictTimes);
  } else {
    echo $query->addSchedules($sched_ay, $sched_sem, $sched_days, $start_time, $end_time, $sched_sub, $sched_room, $sched_fac);
  } 

}

// Fetch School Years From
if (isset($_POST['action']) && $_POST['action'] == 'fetchYearsFrom') {
  echo json_encode($query->fetchSchoolYearsFrom());
}

// Fetch Semesters
if (isset($_POST['action']) && $_POST['action'] == 'fetchSems') {
  echo json_encode($query->fetchSchoolSems());
}

// Fetch Currents
if (isset($_POST['action']) && $_POST['action'] == 'fetchCurrent') {
  echo json_encode($query->fetchCurrents());
}

// Fetch Schedules
if (isset($_POST['action']) && $_POST['action'] == 'fetchSchedules') {
  $ac_year_from = $query->testInput($_POST['ac_year_from']);
  $sem = $query->testInput($_POST['sem']);
  $schedules =  $query->fetchSchedules($ac_year_from, $ac_year_from + 1, $sem);

  $data = [];
  foreach ($schedules as $schedule) {
    $schedule['sch_time_from'] = date("h:ia", strtotime($schedule['sch_time_from']));
    $schedule['sch_time_to'] = date("h:ia", strtotime($schedule['sch_time_to']));
    array_push($data, $schedule);
  }

  echo json_encode($data);
}

// Filter Schedules
if (isset($_POST['action']) && $_POST['action'] == 'filterSchedules') {
  $ac_year_from = $query->testInput($_POST['acyear']);
  $ac_year_to = $ac_year_from + 1;
  $sem = $query->testInput($_POST['sem']);
  echo json_encode($query->fetchSchedules($ac_year_from, $ac_year_to, $sem));
}

// View Schedule
if (isset($_POST['action']) && $_POST['action'] == 'view-sched') {
  $id = $query->testInput($_POST['id']);
  $schedule = $query->fetchSchedule($id);

  $schedule['sch_time_from'] = date("h:ia", strtotime($schedule['sch_time_from']));
  $schedule['sch_time_to'] = date("h:ia", strtotime($schedule['sch_time_to']));

  echo json_encode($schedule);
}

// Edit Schedule
if (isset($_POST['action']) && $_POST['action'] == 'edit-sched') {
  $id = $query->testInput($_POST['id']);
  $schedule = $query->fetchSchedule($id);

  echo json_encode($schedule);
}

// Delete Schedule
if (isset($_POST['action']) && $_POST['action'] == 'del-sched') {
  $id = $query->testInput($_POST['id']);
  echo $query->delSchedule($id);
}

// Update Schedule
if (isset($_POST['action']) && $_POST['action'] == 'updateSchedule') {
  $id = $query->testInput($_POST['edit-sched-id']);
  $sched_ay = $query->testInput($_POST['edit-sched-ay']);
  $sched_sem = $query->testInput($_POST['edit-sched-sem']);

  $sched_days = '';
  if (isset($_POST['edit-sched-days'])) {
    $sched_days = $_POST['edit-sched-days'];
  }

  $start_time = $query->testInput($_POST['edit-start-time']);
  $end_time = $query->testInput($_POST['edit-end-time']);
  $sched_sub = $query->testInput($_POST['edit-sched-sub']);
  $sched_room = $query->testInput($_POST['edit-sched-room']);
  $sched_fac = $query->testInput($_POST['edit-sched-fac']);

  if ($start_time >= $end_time) {
    echo 'time error';
    return;
  }

  if (empty($sched_ay) || empty($sched_sem) || sizeof($sched_days) < 1 || empty($start_time) || empty($end_time) || empty($sched_sub) || empty($sched_room) || empty($sched_fac)) {
    echo 'empty';
    return;
  }

  $schedsWithoutTime = $query->conflictSchedules($sched_ay, $sched_sem, $sched_days, $sched_room);

  $conflictTimes = [];
  foreach ($schedsWithoutTime as $schedWithoutTime) {
    if (strtotime($start_time) >= strtotime($schedWithoutTime['sch_time_from'])) {
      if (strtotime($start_time) < strtotime($schedWithoutTime['sch_time_to'])) {
        $schedWithoutTime['sch_time_from'] = date("h:ia", strtotime($schedWithoutTime['sch_time_from']));
        $schedWithoutTime['sch_time_to'] = date("h:ia", strtotime($schedWithoutTime['sch_time_to']));
        array_push($conflictTimes, $schedWithoutTime);
      }
    } 
    // else if (strtotime($start_time) < strtotime($schedWithoutTime['sch_time_from']) && strtotime($schedWithoutTime['sch_time_from']) >= strtotime($end_time)) {
    //   continue;
    // }
    else if (strtotime($start_time) < strtotime($schedWithoutTime['sch_time_from']) && strtotime($schedWithoutTime['sch_time_from']) < strtotime($end_time)) {
      array_push($conflictTimes, $schedWithoutTime);
    }
  }

  if (sizeof($conflictTimes) > 0) {
    echo json_encode($conflictTimes);
  } else {
    echo $query->updateSchedule($id, $sched_ay, $sched_sem, $sched_days, $start_time, $end_time, $sched_sub, $sched_room, $sched_fac);
  } 

}

// Update Current
if (isset($_POST['action']) && $_POST['action'] == 'updateCurrent') {
  $id = $query->testInput($_POST['cur-id']);
  $cur_year = $query->testInput($_POST['cur-ay']);
  $cur_sem = $query->testInput($_POST['cur-sem']);
  echo $query->updateCurrent($id, $cur_year, $cur_sem);
}