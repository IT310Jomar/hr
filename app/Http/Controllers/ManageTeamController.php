<?php

namespace App\Http\Controllers;

use App\Models\ManageTeam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Employments;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use App\Models\Events;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\TeamEvents;
use App\Models\User;
use DateTime;

class ManageTeamController extends Controller
{
    public function index()
    {

        $manage_team = ManageTeam::latest()->get();

        return response()->json($manage_team);
    }

    public function search()
    {
        $searchQuery = request('query');
        if (!isset($searchQuery) || trim($searchQuery) === '') {
            return response()->json([]);
        }
        $manage_team = Employee::select('*')->whereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE '%{$searchQuery}%'")
            ->orWhere('last_name', 'like', "%{$searchQuery}%")
            ->orWhere('first_name', 'like', "%{$searchQuery}%")
            ->orWhere('middle_name', 'like', "%{$searchQuery}%")
            ->orWhere('id', 'like', "%{$searchQuery}%")
            ->with([
                'employments' => function ($q) {
                    $q->select('*')->with([
                        'schedule_types' => function ($q)  {
                            $q->select('*');
                        }
                    ]);
                }
            ])
            ->with([
                'user' => function ($q) {
                    $q->select('*')->with([
                        'user_levels' => function ($q) {
                            $q->select('*');
                        }
                    ]);
                }
            ])
            ->orWhereHas('user', function ($q) use ($searchQuery) {
                $q->select('*')->where('username', 'like', "%{$searchQuery}%")
                ->orWhereHas('user_levels', function ($q) use ($searchQuery){
                    $q->select('*')->where('name', 'like', "%{$searchQuery}%");
                });
            })
            ->orWhereHas('employments', function ($q) use ($searchQuery) {
                $q->select('*')->where('title', 'like', "%{$searchQuery}%")
                ->orWhereHas('schedule_types', function ($q) use ($searchQuery) {
                    $q->select('*')->where('name', 'like', "%{$searchQuery}%");
                });
            })
            ->get();

        return response()->json([
            'success'       => true,
            'manage_team'   => $manage_team,
        ]);
    }


    public function getSchedule()
    {
        $user = Auth::user();
        $getSched = Employee::select('id', 'user_id')
            ->with([
                'employments' => function ($q) {
                    $q->select('*')->with([
                        'schedule_types' => function ($q) {
                            $q->select('*');
                        }
                    ]);
                }
            ])
            ->with([
                'schedule' => function ($q) {
                    $q->select('*');
                }
            ])
            ->where('user_id', '=', $user->id)
            ->get();

        if ($getSched->isEmpty()) {
            return response()->json([
                'success' => false,
                'getSchedule' => [],
            ]);
        }

        return response()->json([
            'success'       => true,
            'getSchedule'   => $getSched,
        ]);
    }


    public function allEmployee()
    {
        $getAll = Employee::select('*')
            ->with([
                'employments' => function ($q) {
                    $q->select('*')->with([
                        'schedule_types' => function ($q) {
                            $q->select('*');
                        }
                    ]);
                }
            ])
            ->with([
                'user' => function ($q) {
                    $q->select('*')->with([
                        'user_levels' => function ($q) {
                            $q->select('*');
                        }
                    ]);
                }
            ])
            ->get();

        return response()->json([

            'success'       => true,
            'getAll'        => $getAll,
        ]);
    }


    ///////////////////////////////// Calendar /////////////////////////////////
    public function getEvents()
    {
        $filter = request('calendars');
        $filteredData = [];
    
        if($filter == null) {
            $allEvents = [];
            return response()->json([
                'success' => true,
                'events' => $allEvents, // return the accumulated events data
            ]);
        } else {
            foreach($filter as $fil) {
                $filteredData[] = $fil;
            }
    
            $allEvents = []; // create a separate array to accumulate events data
    
            for($i = 0 ; $i < count($filteredData) ; $i++) {
                $events = Events::select('*')
                    ->where('calendar', '=', $filteredData[$i])
                    ->get();
    
                foreach($events as $roles) {
                    $roles->user_level = json_decode($roles->user_level);
                }
    
                // use the array spread operator to merge arrays
                $allEvents = [...$allEvents, ...$events->toArray()]; // add events data to the accumulator array
            }
    
            return response()->json([
                'success' => true,
                'events' => $allEvents,
            ]);
        }
    }


    public function updateEvent($id)
    {
        $event = request('event');

        $updateEvent = Events::find($id);
        $updateEvent->title = $event['title'];
        $updateEvent->start = Carbon::parse($event['start'])->format('Y-m-d H:i:s');
        $updateEvent->end = Carbon::parse($event['end'])->format('Y-m-d H:i:s');
        $updateEvent->calendar = $event['extendedProps']['calendar'];
        $updateEvent->location = $event['extendedProps']['location'];
        $updateEvent->description = $event['extendedProps']['description'];
        $updateEvent->allDay = $event['allDay'];
        $updateEvent->user_level = json_encode($event['extendedProps']['user_level']);
        $updateEvent->save();

        $updateEvent->user_level = json_decode($updateEvent->user_level);
        return response()->json([
            'success'       => true,
            'updateEvent'   => $updateEvent,
        ]);
    }


    public function addEvent()
    {
        $add_event = new Events();
        $event = request('event');
        // return response()->json($event);
        $add_event->title = $event['title'];
        $add_event->start = Carbon::parse($event['start'])->format('Y-m-d H:i:s');
        $add_event->end = Carbon::parse($event['end'])->format('Y-m-d H:i:s');
        // $add_event->url = $event['url'];
        $add_event->calendar = $event['extendedProps']['calendar'];
        $add_event->location = $event['extendedProps']['location'];
        $add_event->description = $event['extendedProps']['description'];
        $add_event->user_level = json_encode($event['extendedProps']['user_level']);
        $add_event->save();

        return response()->json([
            'success' => true,
            'addEvent'  => $add_event,
        ]);
    }

    public function deleteEvent($id)
    {
        $deleteEvent = Events::find($id);
        $deleteEvent->delete();

        return response()->json([
            'success'   => true,
            'deleted'   => $deleteEvent,
        ]);
    }


    /////////////////////////////// Team Atteandance ///////////////////////////

    public function getTeamAttendance() 
    {

    $searchRange = request('dateRange');
 
    $dates = explode(' to ', $searchRange);

    if(!empty($searchRange)) {
       
        $attendance = Attendance::select('*')
        ->whereBetween('login', [$dates[0], $dates[1]])
        ->with([
            'employee' => function ($q) {
                $q->select('id', 'last_name', 'first_name', 'middle_name');
            }
        ])
        ->with([
            'users' => function ($q) {
                $q->select('*')->with([
                    'schedule' => function ($s) {
                        $s->select('day', 'shift_start', 'shift_end', 'user_id', 'employee_id');
                    }
                ]); 
            }
        ])
        ->get();
    } else {
        $attendance = Attendance::select('*')
        ->with([
            'employee' => function ($q) {
                $q->select('id', 'last_name', 'first_name', 'middle_name');
            }
        ])
        ->with([
            'users' => function ($q) {
                $q->select('*')->with([
                    'schedule' => function ($s) {
                        $s->select('day', 'shift_start', 'shift_end', 'user_id', 'employee_id');
                    }
                ]); 
            }
        ])
        ->get();
    }
        $attendanceData = [];

        foreach ($attendance as $record) {
            $login = $record->login;
            $employee = $record->employee;
            $startDate = '1990-04-01';
            $endDate =  Carbon::now()->format('Y-m-d');
            $timeIn = Carbon::createFromFormat('H:i:s', $record->timeIn);
            $timeOut = Carbon::createFromFormat('H:i:s', $record->timeOut);

            for($i = 0 ; $i < count($record->users->schedule); $i++) {
                $shift_start = Carbon::createFromFormat('H:i:s', $record->users->schedule[$i]->shift_start);
                $shift_end = Carbon::createFromFormat('H:i:s', $record->users->schedule[$i]->shift_end);
            }

            $diffInSeconds = $shift_start->diffInSeconds($timeIn);
            $underTime = $timeIn->diffInSeconds($timeOut);
            $totalTodif = $diffInSeconds + $underTime;
            
            $totalHrs = $timeIn->addHours($timeOut->diffInSeconds());
            $userSchedule = $record->users->schedule;
    
            $absentDays = [];
    
            if (!$userSchedule) {
                // User does not have a schedule, so mark all days as absent
                $absentDays = range($startDate, $endDate);
            } else {
                foreach (range($startDate, $endDate) as $day) {
                    $dayOfWeek = date('N', strtotime($day));
    
                    // Check if the user has a schedule for this day
                    $scheduleForDay = $userSchedule->where('day', $dayOfWeek)->all();
    
                    if ($scheduleForDay) {
                        // Check if the user clocked in and out for this day
                        $attendanceForDay = $record->attendance->where('date', $day)->all();
    
                        if (!$attendanceForDay || !$attendanceForDay->clock_in || !$attendanceForDay->clock_out) {
                            // User did not clock in or out, so mark as absent
                            $absentDays[] = $day;
                        }
                    } else {
                        // User does not have a schedule for this day, so mark as absent
                        $absentDays[] = $day;
                    }
                }
            }
            $abDays  = json_encode($absentDays);
            $attendanceData[] = [
                'totalHrs'                      => $totalHrs,
                'totalTodif'                    => $totalTodif,
                'underTime'                     => $underTime,
                'diffInSeconds'                 => $diffInSeconds,
                'shift_start'                   => $shift_start,
                'shift_end'                     => $shift_end,
                'timOut'                        => $timeOut,
                'timeIn'                        => $timeIn,
                'login'                         => $login,
                'employee'                      => $employee,
                'absent_days'                   => json_decode($abDays),
            ];
        }

        return response()->json([
            'success' => true,
            'employee_attendance'       => $attendanceData,
        ]);
    }


    //////////////////////////////// Team Calenar ///////////////////////////////////////


    public function getTeamEvents()
    {
        $filter = request('calendars');
        $filteredData = [];
    
        if($filter == null) {
            $allEvents = [];
            return response()->json([
                'success' => true,
                'events' => $allEvents, // return the accumulated events data
            ]);
        } else {
            foreach($filter as $fil) {
                $filteredData[] = $fil;
            }
            $allEvents = []; // create a separate array to accumulate events data
            for($i = 0 ; $i < count($filteredData) ; $i++) {
                $events = TeamEvents::select('*')
                    ->where('calendar', '=', $filteredData[$i])
                    ->get();
    
                foreach($events as $roles) {
                    $roles->employee_id = json_decode($roles->employee_id);
                }
    
                // use the array spread operator to merge arrays
                $allEvents = [...$allEvents, ...$events->toArray()]; // add events data to the accumulator array
            }
    
            return response()->json([
                'success' => true,
                'events' => $allEvents,
            ]);
        }
    }

    public function getEmployees() {

        $employee = Employee::all();

        return response()->json([
            'success'           => true,
            'employees'         => $employee,
        ]);
    }
    
    
    public function addTeamEvent()
    {
        $add_team_event = new TeamEvents();
        $event = request('event');
       
        $add_team_event->title = $event['title'];
        $add_team_event->start = Carbon::parse($event['start'])->format('Y-m-d H:i:s');
        $add_team_event->end = Carbon::parse($event['end'])->format('Y-m-d H:i:s');
        
        $add_team_event->calendar = $event['extendedProps']['calendar'];
        $add_team_event->reason = $event['extendedProps']['reason'];
        $add_team_event->employee_id = json_encode($event['extendedProps']['employee_id']);
        $add_team_event->save();

        return response()->json([
            'success' => true,
            'addEvent'  => $add_team_event,
        ]);
    }

    public function updateTeamEvent($id)
    {
        $event = request('event');
       
        $updateEvent = TeamEvents::find($id);
        $updateEvent->title = $event['title'];
        $updateEvent->start = Carbon::parse($event['start'])->format('Y-m-d H:i:s');
        $updateEvent->end = Carbon::parse($event['end'])->format('Y-m-d H:i:s');
        $updateEvent->calendar = $event['extendedProps']['calendar'];
        $updateEvent->reason = $event['extendedProps']['reason'];
        $updateEvent->allDay = $event['allDay'];
        $updateEvent->employee_id = json_encode($event['extendedProps']['employee_id']);
        $updateEvent->save();

        $updateEvent->employee_id = json_decode($updateEvent->employee_id);
        return response()->json([
            'success'       => true,
            'updateEvent'   => $updateEvent,
        ]);
    }


    public function deleteTeamEvent($id)
    {
        $deleteTeamEvent = TeamEvents::find($id);
        $deleteTeamEvent->delete();

        return response()->json([
            'success'   => true,
            'deleted'   => $deleteTeamEvent,
        ]);
    }
    
}
