// Purpose : This function will check if user attendance is in first half he cant apply leave in first half or vice versa
// Input Parameter : $faculty_id, $institute_id, $from_date, $to_date
// Mandatory Fields : $faculty_id, $institute_id, $from_date, $to_date
// Output : Will return false a message can't apply leave in first half
// Reference Id : SS1208202301

function leaveApplicationValidationAccordingToAttendancePolicy($inputParameters)
{
    global $link;
    $response = [];

    $iid = $inputParameters['institute_id'];
    $facultyId = $inputParameters['faculty_id'];
    $fromDate = new DateTime($inputParameters['from_date']);
    $toDate = new DateTime($inputParameters['to_date']);

    if (!empty($iid) && !empty($facultyId) && !empty($fromDate) && !empty($toDate)) 
    {
        $response['success'] = 'true';

        $monthsArray = [];

        // Iterate over each day in the date range
        $currentDate = clone $fromDate;
        while ($currentDate <= $toDate) {
            $year = $currentDate->format('Y');
            $month = $currentDate->format('m');
            
            // Add the month to the monthsArray if it's not already added
            if (!in_array([$month, $year], $monthsArray)) {
                $monthsArray[] = [$month, $year];
            }

            // Add the year to the yearsArray if it's not already added
            if (!in_array($year, $yearsArray)) {
                $yearsArray[] = $year;
            }
            // Move to the next day
            $currentDate->modify('+1 day');
        }
        
        $facultyGetTableName = "faculty_registration";
        $facultyGetWHERECondition = "faculty_id = ?";
        $facultyGetSelectQuery = $link->prepare("SELECT defaultDepartmentId, userrole FROM ".$facultyGettableName." WHERE ".$facultyGetWHERECondition);
        $facultyGetSelectQuery->bind_param("i",$iid);
        $facultyGetSelectQuery->execute();
        $facultyGetQueryResult = $facultyGetSelectQuery->get_result();
        $facultyResult = mysqli_fetch_assoc($facultyGetQueryResult);
        
        $department = $facultyResult['defaultDepartmentId'];
        $role = $facultyResult['userrole'];
        
        $weekNumber = $currentDate->format('W');
        $dayOfWeek = $currentDate->format('l');

        $timeStructureSelectQueryTable = 'leavetemplate';
        $timeStructureSelectQueryWHERECondition = "department = ? AND role = ?";
        $timeStructureSelectQuery = $link->prepare("SELECT timingStructure FROM ".$timeStructureSelectQueryTable." WHERE ".$timeStructureSelectQueryWHERECondition);
        $timeStructureSelectQuery->bind_param("is", $department, $role);
        $timeStructureSelectQuery->execute();
        $timeStructureSelectResult = $timeStructureSelectQuery->get_result();
        $timeStructureResult = mysqli_fetch_assoc($timeStructureSelectResult);

        $timeStructure = $timeStructureResult['timingStructure'];
        $timeStructure = json_decode($timeStructure,true); //GOT TIME STRUCTURE

        $attendance = []

        foreach ($monthsArray as $monthYear) {
            $attendanceTableName = 'leave_employee_attendance';
            $attendanceWHERECondition = 'employee_id = ? and year = ? and month = ?';
            $attendanceSelectQuery = $link->prepare("SELECT monthly_attendance_json FROM ".$attendanceTableName." WHERE ".$attendanceWHERECondition);
            $attendanceSelectQuery->bind_param('iii', $facultyId, $monthYear[1], $monthYear[0]);
            $attendanceSelectQuery->execute();
            $attendanceSelectResult = $attendanceSelectQuery->get_result();
            $attendanceResult = mysqli_fetch_assoc($attendanceSelectResult);

            $monthlyAttendance = $attendanceResult['monthly_attendance_json'];
            $monthlyAttendance = json_decode($monthlyAttendance, true); //GOT ATTENDANCE
        }
    }
}



'11', '113', '1823', '2021', '1', '{\"1\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:00:00\"},\"2\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:00:00\"},\"3\":{\"inTime\":\"09:55:00\",\"outTime\":\"09:55:00\"},\"4\":{\"inTime\":\"09:55:00\",\"outTime\":\"09:55:00\"},\"5\":{\"inTime\":\"09:55:00\",\"outTime\":\"09:55:00\"},\"6\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"7\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"8\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"9\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"10\":{\"inTime\":\"09:55:00\",\"outTime\":\"09:55:00\"},\"11\":{\"inTime\":\"09:55:00\",\"outTime\":\"18:30:00\"},\"12\":{\"inTime\":\"09:55:00\",\"outTime\":\"18:30:00\"},\"13\":{\"inTime\":\"09:00:00\",\"outTime\":\"\"},\"14\":{\"inTime\":\"09:00:00\",\"outTime\":\"\"},\"15\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"16\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"17\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"18\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"19\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"20\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"21\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"22\":{\"inTime\":\"09:00:00\",\"outTime\":\"\"},\"23\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"24\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"25\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"26\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"27\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"28\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"29\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"30\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"31\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"},\"01\":{\"inTime\":\"09:00:00\",\"outTime\":\"18:30:00\"}}', '1823', '2021-01-15 09:10:08'
