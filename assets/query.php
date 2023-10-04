<?php

require_once './db.php';

class Query extends Database {
  // Fetch Admin through username
  public function fetchAdminUser($user) {
    $sql = "SELECT * FROM admin WHERE username = :user";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['user' => $user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  // Add Faculty
  public function addFaculty($fname, $mname, $lname, $dep, $gen, $img, $qrcode, $qrcode_img) {
    $sql = "INSERT INTO faculty (fac_fname, fac_mname, fac_lname, fac_img, dep_id, gender, qrcode, qrcode_img) 
            VALUES (:fname, :mname, :lname, :img, :dep_id, :gender, :qrcode, :qrcode_img)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      'fname' => $fname,
      'mname' => $mname,
      'lname' => $lname,
      'img' => $img,
      'dep_id' => $dep,
      'gender' => $gen,
      'qrcode' => $qrcode,
      'qrcode_img' => $qrcode_img
    ]);
    return true;
  }

  // Fetch Faculties
  public function fetchFaculties() {
    $sql = "SELECT * FROM faculty INNER JOIN department ON faculty.dep_id = department.dep_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // Fetch a faculty
  public function fetchFaculty($id) {
    $sql = "SELECT * FROM faculty INNER JOIN department ON faculty.dep_id = department.dep_id WHERE fac_id = :fac_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['fac_id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  // Update faculty with image
  public function updateFacultyWithImg($id, $fname, $mname, $lname, $dep, $gen, $img) {
    $sql = "UPDATE faculty
            SET fac_fname = :fac_fname,
              fac_mname = :fac_mname,
              fac_lname = :fac_lname,
              fac_img = :fac_img,
              dep_id = :dep_id,
              gender = :gender
            WHERE fac_id = :fac_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      'fac_id' => $id,
      'fac_fname' => $fname,
      'fac_mname' => $mname,
      'fac_lname' => $lname,
      'fac_img' => $img,
      'dep_id' => $dep,
      'gender' => $gen
    ]);
    return true;
  }

  // Update faculty without image
  public function updateFacultyWithoutImg($id, $fname, $mname, $lname, $dep, $gen) {
    $sql = "UPDATE faculty
            SET fac_fname = :fac_fname,
              fac_mname = :fac_mname,
              fac_lname = :fac_lname,
              dep_id = :dep_id,
              gender = :gender
            WHERE fac_id = :fac_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      'fac_id' => $id,
      'fac_fname' => $fname,
      'fac_mname' => $mname,
      'fac_lname' => $lname,
      'dep_id' => $dep,
      'gender' => $gen
    ]);
    return true;
  }

  // Delete faculty
  public function delFaculty($id) {
    $sql = "DELETE FROM faculty WHERE fac_id = :fac_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['fac_id' => $id]);
    return true;
  }

  // Add Department
  public function addDep($dep_name, $dep_desc) {
    $sql = "INSERT INTO department (dep_name, dep_desc) VALUES (:dep_name, :dep_desc)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['dep_name' => $dep_name, 'dep_desc' => $dep_desc]);
    return true;
  }

  // Fetch Departments
  public function fetchDeps() {
    $sql = "SELECT * FROM department";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // Fetch Department
  public function fetchDep($id) {
    $sql = "SELECT * FROM department WHERE dep_id = :dep_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['dep_id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  // Update Department
  public function updateDep($id, $dep, $desc) {
    $sql = "UPDATE department SET dep_name = :dep_name, dep_desc = :dep_desc WHERE dep_id = :dep_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['dep_id' => $id, 'dep_name' => $dep, 'dep_desc' => $desc]);
    return true;
  }

  // Delete Department
  public function delDep($id) {
    $sql = "DELETE FROM department WHERE dep_id = :dep_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['dep_id' => $id]);
    return true;
  }

  // Check if department data is used by faculties
  public function depExistsInFaculty($dep_id) {
    $sql = "SELECT * FROM faculty WHERE dep_id = :dep_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['dep_id' => $dep_id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // Add Department
  public function addRoom($rname, $rbldg) {
    $sql = "INSERT INTO room (room, bldg) VALUES (:room, :bldg)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['room' => $rname, 'bldg' => $rbldg]);
    return true;
  }

  // Fetch Rooms
  public function fetchRooms() {
    $sql = "SELECT * FROM room";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // Fetch Room
  public function fetchRoom($id) {
    $sql = "SELECT * FROM room WHERE ro_id = :ro_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['ro_id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  }
  
  // Update Room
  public function updateRoom($id, $room, $bldg) {
    $sql = "UPDATE room
            SET room = :room,
              bldg = :bldg
            WHERE ro_id = :ro_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      'ro_id' => $id,
      'room' => $room,
      'bldg' => $bldg
    ]);
    return true;
  }

  // Delete Room
  public function delRoom($id) {
    $sql = "DELETE FROM room WHERE ro_id = :ro_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['ro_id' => $id]);
    return true;
  }

  // Add subject
  public function addSubject($code, $title, $desc) {
    $sql = "INSERT INTO subject (sub_code, sub_title, sub_desc) VALUES (:code, :title, :desc)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      'code' => $code,
      'title' => $title,
      'desc' => $desc
    ]);
    return true;
  }

  // Fetch subjects
  public function codeExistsInSubj($code) {
    $sql = "SELECT * FROM subject WHERE sub_code = :code";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['code' => $code]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // Fetch subjects
  public function fetchSubjects() {
    $sql = "SELECT * FROM subject";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // Fetch subject
  public function fetchSubject($id) {
    $sql = "SELECT * FROM subject WHERE sub_id = :sub_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['sub_id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  }
  
  // Delete subject
  public function delSubject($id) {
    $sql = "DELETE FROM subject WHERE sub_id = :sub_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['sub_id' => $id]);
    return true;
  }

  // Update Subject
  public function updateSubject($id, $code, $title, $desc) {
    $sql = "UPDATE subject
            SET sub_code = :code,
              sub_title = :title,
              sub_desc = :desc
            WHERE sub_id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      'id' => $id,
      'code' => $code,
      'title' => $title,
      'desc' => $desc
    ]);
    return true;
  }

  // Check if subject is used in schedules
  public function subjectUsedInSchedules($id) {
    $sql = "SELECT * FROM schedule WHERE sub_id = :sub_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['sub_id' => $id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  
  // Check if room is used in schedules
  public function roomUsedInSchedules($id) {
    $sql = "SELECT * FROM schedule WHERE ro_id = :ro_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['ro_id' => $id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  
  // Check if faculty is used in schedules
  public function facultyUsedInSchedules($id) {
    $sql = "SELECT * FROM schedule WHERE fac_id = :fac_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['fac_id' => $id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // Fetch schedules
  public function fetchSchedules($ac_year_from, $ac_year_to, $sem) {
    $sql = "SELECT * FROM schedule
            INNER JOIN faculty
              ON schedule.fac_id = faculty.fac_id
            INNER JOIN department
              ON faculty.dep_id = department.dep_id
            INNER JOIN room
              ON schedule.ro_id = room.ro_id
            INNER JOIN subject
              ON schedule.sub_id = subject.sub_id
            WHERE school_year_from = :school_year_from
              AND school_year_to = :school_year_to
              AND sem = :sem";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      'school_year_from' => $ac_year_from,
      'school_year_to' => $ac_year_to,
      'sem' => $sem
    ]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // Add schedules
  public function addSchedules($sched_ay, $sched_sem, $sched_days, $start_time, $end_time, $sched_sub, $sched_room, $sched_fac) {
    foreach ($sched_days as $day) {
      $sql = "INSERT INTO schedule (school_year_from, school_year_to, sem, sch_time_from, sch_time_to, `day`, ro_id, sub_id, fac_id)
              VALUES (:school_year_from, :school_year_to, :sem, :sch_time_from, :sch_time_to, :sch_day, :ro_id, :sub_id, :fac_id)";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        'school_year_from' => $sched_ay,
        'school_year_to' => $sched_ay + 1,
        'sem' => $sched_sem,
        'sch_day' => $day,
        'sch_time_from' => $start_time,
        'sch_time_to' => $end_time,
        'sub_id' => $sched_sub,
        'ro_id' => $sched_room,
        'fac_id' => $sched_fac
      ]);
    }
    return true;
  } 

  // Check conflict schedules
  public function conflictSchedules($sched_ay, $sched_sem, $sched_days, $sched_room) {
    $scheds = [];
    foreach ($sched_days as $day) {
      $sql = "SELECT * FROM schedule
              INNER JOIN room
                ON schedule.ro_id = room.ro_id
              INNER JOIN `subject`
                ON schedule.sub_id = `subject`.sub_id
              INNER JOIN faculty
                ON schedule.fac_id = faculty.fac_id
              INNER JOIN department
                ON faculty.dep_id = department.dep_id
              WHERE school_year_from = :school_year_from
                AND school_year_to = :school_year_to
                AND sem = :sem
                AND `day` = :sch_day
                AND schedule.ro_id = :ro_id";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        'school_year_from' => $sched_ay,
        'school_year_to' => $sched_ay + 1,
        'sem' => $sched_sem,
        'sch_day' => $day,
        'ro_id' => $sched_room
      ]);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($result as $row) {
        array_push($scheds, $row);
      }
    }
    return $scheds;
  }

  // Fetch unique school year from
  public function fetchSchoolYearsFrom() {
    $sql = "SELECT DISTINCT school_year_from FROM schedule ORDER BY school_year_from DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  
  // Fetch unique school semester
  public function fetchSchoolSems() {
    $sql = "SELECT DISTINCT sem FROM schedule ORDER BY sem ASC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // Fetch unique school semester
  public function fetchCurrents() {
    $sql = "SELECT * FROM current";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  // Fetch a schedule
  public function fetchSchedule($id) {
    $sql = "SELECT * FROM schedule
            INNER JOIN faculty
              ON schedule.fac_id = faculty.fac_id
            INNER JOIN department
              ON faculty.dep_id = department.dep_id
            INNER JOIN room
              ON schedule.ro_id = room.ro_id
            INNER JOIN subject
              ON schedule.sub_id = subject.sub_id
            WHERE sch_id = :sch_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['sch_id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  // Delete a schedule
  public function delSchedule($id) {
    $sql = "DELETE FROM schedule WHERE sch_id = :sch_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['sch_id' => $id]);
    return true;
  }

  // Update schedules
  // public function updateSchedule($id, $sched_ay, $sched_sem, $sched_days, $start_time, $end_time, $sched_sub, $sched_room, $sched_fac) {
  //   $sql = "UPDATE schedule
  //           SET ";
  //   $stmt = $this->conn->prepare($sql);
  //   $stmt->execute([
  //     'sch_id' => $id,
  //     'school_year_from' => $sched_ay,
  //     'school_year_to' => $sched_ay + 1,
  //     'sem' => $sched_sem,
  //     'sch_day' => $day,
  //     'sch_time_from' => $start_time,
  //     'sch_time_to' => $end_time,
  //     'sub_id' => $sched_sub,
  //     'ro_id' => $sched_room,
  //     'fac_id' => $sched_fac
  //   ]);
  //   return true;
  // } 
}