<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Attendance;
use App\Models\CashAdvance;
use App\Models\LeaveRequest;
use App\Models\OfficialBusinessRequest;
use App\Models\OvertimeRequest;
use App\Models\RequestTypes;
use App\Models\ScheduleAdjustment;
use App\Models\Types;
use App\Models\UndertimeRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResolutionController extends Controller
{

    //Query the data based on their Status
    public function requestCashAdPending()
    {
        $from = request('dfrom');
        $to = request('dto');
        $department = request('department');
        $employeeID = request('employeeID');
        $selectedTypes = request('types');

        if(!empty($from) || !empty($to) || !empty($employeeID) || !empty($department)) {
            $cashAdvancePending = CashAdvance::latest()
            ->whereBetween('requested_date', [$from, $to] ?? null)
            ->where('employee_id', '=', $employeeID['value'] ?? null)
            ->where('type_id', '=', $selectedTypes ?? null)
            ->with([
                'employee' => function ($q){
                    $q->select('*')
                    ->with([
                        'employments' => function ($q) {
                            $q->select('*')->with([
                                'departments'   => function ($q) {
                                    $q->select('*');
                                }
                            ]);
                        }
                    ])
                    ->with([
                        'attendance_logs'  => function ($q) {
                            $q->select('*');
                        }
                    ])
                    ->with([
                        'user'  => function ($q) {
                            $q->select('*');
                        }
                    ]);
                }
            ])
            ->with([
                'types' => function ($q) {
                    $q->select('*');
                }
            ])
            ->whereHas('employee', function($q) use ($department) {
                $q->select('*')->whereHas('employments', function ($q) use ($department) {
                    $q->select('*')->where('department_id', '=', $department['value']?? null);
                });
            })
            ->get();

          $officialBusiness = OfficialBusinessRequest::latest()
          ->whereBetween('date_from', [$from, $to])
          ->where('employee_id', '=', $employeeID['value'] ?? null)
          ->with([
            'employee' => function ($q){
                    $q->select('*')
                    ->with([
                        'employments' => function ($q) {
                            $q->select('*')->with([
                                'departments'   => function ($q) {
                                    $q->select('*');
                                }
                            ]);
                        }
                    ])
                    ->with([
                        'attendance_logs'  => function ($q) {
                            $q->select('*');
                        }
                    ])
                    ->with([
                        'user'  => function ($q) {
                            $q->select('*');
                        }
                    ]);
                }
            ])
            ->whereHas('employee', function($q) use ($department) {
                $q->select('*')->orWhereHas('employments', function ($q) use ($department) {
                    $q->select('*')->where('department_id', '=', $department['value'] ?? null);
                });
            })->get();

            $sched_adjustment = ScheduleAdjustment::latest()
            ->whereBetween('date_from', [$from, $to])
            ->where('employee_id', '=', $employeeID['value'] ?? null)
            ->with([
                'employee' => function ($q){
                        $q->select('*')
                        ->with([
                            'employments' => function ($q) {
                                $q->select('*')->with([
                                    'departments'   => function ($q) {
                                        $q->select('*');
                                    }
                                ]);
                            }
                        ])
                        ->with([
                            'attendance_logs'  => function ($q) {
                                $q->select('*');
                            }
                        ])
                        ->with([
                            'user'  => function ($q) {
                                $q->select('*');
                            }
                        ]);
                    }
                ])
                ->whereHas('employee', function($q) use ($department) {
                    $q->select('*')->orWhereHas('employments', function ($q) use ($department) {
                        $q->select('*')->where('department_id', '=', $department['value'] ?? null);
                    });
                })->get();
            
            $certificate_Att = Attendance::where('status_id', '=', 'Pending')
            ->with([
                'employee' => function ($q){
                        $q->select('*')
                        ->with([
                            'employments' => function ($q) {
                                $q->select('*')->with([
                                    'departments'   => function ($q) {
                                        $q->select('*');
                                    }
                                ]);
                            }
                        ])
                        ->with([
                            'user'  => function ($q) {
                                $q->select('*');
                            }
                        ]);
                    }
                ])->get();

                $sick_vacation_leave = LeaveRequest::latest()
                ->whereBetween('date_from', [$from, $to])
                ->where('employee_id', '=', $employeeID['value'] ?? null)
                ->with([
                    'employee' => function ($q){
                            $q->select('*')
                            ->with([
                                'employments' => function ($q) {
                                    $q->select('*')->with([
                                        'departments'   => function ($q) {
                                            $q->select('*');
                                        }
                                    ]);
                                }
                            ])
                            ->with([
                                'attendance_logs'      => function ($q) {
                                    $q->select('*');
                                }
                            ])
                            ->with([
                                'user'  => function ($q) {
                                    $q->select('*');
                                }
                            ]);
                        }
                    ])
                    ->whereHas('employee', function($q) use ($department) {
                        $q->select('*')->orWhereHas('employments', function ($q) use ($department) {
                            $q->select('*')->where('department_id', '=', $department['value'] ?? null);
                        });
                    })->get();

                $underTime = UndertimeRequest::latest()
                ->whereBetween('date_req', [$from, $to])
                ->where('employee_id', '=', $employeeID['value'] ?? null)
                ->with([
                    'employee' => function ($q){
                            $q->select('*')
                            ->with([
                                'employments' => function ($q) {
                                    $q->select('*')->with([
                                        'departments'   => function ($q) {
                                            $q->select('*');
                                        }
                                    ]);
                                }
                            ])
                            ->with([
                                'attendance_logs'      => function ($q) {
                                    $q->select('*');
                                }
                            ])
                            ->with([
                                'user'  => function ($q) {
                                    $q->select('*');
                                }
                            ]);
                        }
                    ])
                    ->whereHas('employee', function($q) use ($department) {
                        $q->select('*')->orWhereHas('employments', function ($q) use ($department) {
                            $q->select('*')->where('department_id', '=', $department['value'] ?? null);
                        });
                    })->get();

                $overtime = OvertimeRequest::latest()
                ->whereBetween('shift_date', [$from, $to])
                ->where('employee_id', '=', $employeeID['value'] ?? null)
                ->with([
                    'employee' => function ($q){
                            $q->select('*')
                            ->with([
                                'employments' => function ($q) {
                                    $q->select('*')->with([
                                        'departments'   => function ($q) {
                                            $q->select('*');
                                        }
                                    ]);
                                }
                            ])
                            ->with([
                                'attendance_logs'      => function ($q) {
                                    $q->select('*');
                                }
                            ])
                            ->with([
                                'user'  => function ($q) {
                                    $q->select('*');
                                }
                            ]);
                        }
                    ])
                    ->whereHas('employee', function($q) use ($department) {
                        $q->select('*')->orWhereHas('employments', function ($q) use ($department) {
                            $q->select('*')->where('department_id', '=', $department['value'] ?? null);
                        });
                    })->get();
            
            } else {

                $cashAdGet = CashAdvance::all();
                $schedAdGet = ScheduleAdjustment::all();

                foreach ($cashAdGet as $cashAdvance) {
                    if (Carbon::parse($cashAdvance->requested_date)->lessThan(Carbon::now())) {
                        $cashAdvance->type_id = 1;
                        $cashAdvance->save();
                    }
                }

                foreach ($schedAdGet as $schedAd) {
                    if (Carbon::parse($schedAd->date_from)->lessThan(Carbon::now())) {
                        $schedAd->type_id = 2;
                        $schedAd->save();
                    }
                }

                $cashAdvancePending = CashAdvance::latest()
                ->with([
                    'employee' => function ($q){
                        $q->select('*')
                        ->with([
                            'employments' => function ($q) {
                                $q->select('*')->with([
                                    'departments'   => function ($q) {
                                        $q->select('*');
                                    }
                                ]);
                            }
                        ])
                        ->with([
                            'attendance_logs'      => function ($q) {
                                $q->select('*');
                            }
                        ])
                        ->with([
                            'user'  => function ($q) {
                                $q->select('*');
                            }
                        ]);
                    }
                ])
                ->with([
                    'types' => function ($q) {
                        $q->select('*');
                    }
                ])
                ->get();


                $officialBusiness = OfficialBusinessRequest::latest()
                ->with([
                    'employee' => function ($q){
                            $q->select('*')
                            ->with([
                                'employments' => function ($q) {
                                    $q->select('*')->with([
                                        'departments'   => function ($q) {
                                            $q->select('*');
                                        }
                                    ]);
                                }
                            ])
                            ->with([
                                'attendance_logs'  => function ($q) {
                                    $q->select('*');
                                }
                            ])
                            ->with([
                                'user'  => function ($q) {
                                    $q->select('*');
                                }
                            ]);
                        }
                    ])->get();

                $sched_adjustment = ScheduleAdjustment::latest()
                ->with([
                    'employee' => function ($q){
                            $q->select('*')
                            ->with([
                                'employments' => function ($q) {
                                    $q->select('*')->with([
                                        'departments'   => function ($q) {
                                            $q->select('*');
                                        }
                                    ]);
                                }
                            ])
                            ->with([
                                'attendance_logs'  => function ($q) {
                                    $q->select('*');
                                }
                            ])
                            ->with([
                                'user'  => function ($q) {
                                    $q->select('*');
                                }
                            ]);
                        }
                    ])
                    ->with([
                        'types' => function ($q) {
                            $q->select('*');
                        }
                    ])->get();
                $certificate_Att = Attendance::where('status_id', '=', 'Pending')
                ->with([
                    'employee' => function ($q){
                            $q->select('*')
                            ->with([
                                'employments' => function ($q) {
                                    $q->select('*')->with([
                                        'departments'   => function ($q) {
                                            $q->select('*');
                                        }
                                    ]);
                                }
                            ])
                            ->with([
                                'attendance_logs'      => function ($q) {
                                    $q->select('*');
                                }
                            ])
                            ->with([
                                'user'  => function ($q) {
                                    $q->select('*');
                                }
                            ]);
                        }
                    ])->get();
                $sick_vacation_leave = LeaveRequest::latest()
                ->with([
                    'employee' => function ($q){
                            $q->select('*')
                            ->with([
                                'employments' => function ($q) {
                                    $q->select('*')->with([
                                        'departments'   => function ($q) {
                                            $q->select('*');
                                        }
                                    ]);
                                }
                            ])
                            ->with([
                                'attendance_logs'      => function ($q) {
                                    $q->select('*');
                                }
                            ])
                            ->with([
                                'user'  => function ($q) {
                                    $q->select('*');
                                }
                            ]);
                        }
                    ])->get();
                $underTime = UndertimeRequest::latest()
                ->with([
                    'employee' => function ($q){
                            $q->select('*')
                            ->with([
                                'employments' => function ($q) {
                                    $q->select('*')->with([
                                        'departments'   => function ($q) {
                                            $q->select('*');
                                        }
                                    ]);
                                }
                            ])
                            ->with([
                                'attendance_logs'      => function ($q) {
                                    $q->select('*');
                                }
                            ])
                            ->with([
                                'user'  => function ($q) {
                                    $q->select('*');
                                }
                            ]);
                        }
                    ])->get();

                $overtime = OvertimeRequest::latest()
                ->with([
                    'employee' => function ($q){
                            $q->select('*')
                            ->with([
                                'employments' => function ($q) {
                                    $q->select('*')->with([
                                        'departments'   => function ($q) {
                                            $q->select('*');
                                        }
                                    ]);
                                }
                            ])
                            ->with([
                                'attendance_logs'      => function ($q) {
                                    $q->select('*');
                                }
                            ])
                            ->with([
                                'user'  => function ($q) {
                                    $q->select('*');
                                }
                            ]);
                        }
                    ])->get();

                }

            $allData[] = [
                'cash_advancePending'   => $cashAdvancePending,
                'officialBusiness'      => $officialBusiness,
                'sched_adjustment'      => $sched_adjustment,
                'certificate_Att'       => $certificate_Att,
                'sick_vacation_leave'   => $sick_vacation_leave,
                'underTime'             => $underTime,
                'overtime'              => $overtime,
            ];
        return response()->json(['success' => true, 'allData' => $allData], 200);
    }

    public function requestCashAdApprove()
    {
        $cashAdvanceApproved = CashAdvance::latest()->where('request_status', '=', 'Approved')
        ->with([
            'employee' => function ($q){
                $q->select('*');
            }
        ])
        ->get();
        return response()->json(['success' => true, 'cashAdvanceApproved' => $cashAdvanceApproved], 200);
    }

    public function getRequestTypes() {
        $requestTypes = RequestTypes::all();
        return response()->json([
            'success'       => true,
            'requestTypes'  => $requestTypes,
        ]);
    }

    public function getCompany() {
        $company = Account::all();

        return response()->json([
            'success'       => true,
            'company'       => $company,
        ]);
    }

    public function getTypes() {
        $types = Types::all();

        return response()->json([
            'success'       => true,
            'types'         => $types,
        ]);
    }

    public function deleteRequest($id) {
        $deleteSched = ScheduleAdjustment::findOrFail($id);
        if($deleteSched) {
            $deleteSched->delete();
            return response()->json([
                'success'      => true,
                'deleteSched'  => $deleteSched,          
            ]);
        }
    }

    public function deleteRequestCashAd($id) {
        $deleteCashAd = CashAdvance::findOrFail($id);
    
        if ($deleteCashAd) {
            $deleteCashAd->delete();
            return response()->json([
                'success'      => true,
                'deleteCashAd' => $deleteCashAd,          
            ]);
        }
    }

    public function deleteRequestLeave($id) {
        $deleteLeave = LeaveRequest::findOrFail($id);
    
        if ($deleteLeave) {
            $deleteLeave->delete();
            return response()->json([
                'success'      => true,
                'deleteLeave' => $deleteLeave,          
            ]);
        }
    }

    public function deleteRequestOffBusiness($id) {
        $deleteOffBussines = OfficialBusinessRequest::findOrFail($id);
        if ($deleteOffBussines) {
            $deleteOffBussines->delete();
            return response()->json([
                'success'      => true,
                'deleteOffBussines' => $deleteOffBussines,          
            ]);
        }
    }

    public function deleteRequesOvertime($id) {
        $deleteOvertime = OvertimeRequest::findOrFail($id);
        if ($deleteOvertime) {
            $deleteOvertime->delete();
            return response()->json([
                'success'      => true,
                'deleteOvertime' => $deleteOvertime,          
            ]);
        }
    }

    public function deleteRequesAttendance($id) {
        $deleteAttendance = Attendance::findOrFail($id);
        if ($deleteAttendance) {
            $deleteAttendance->delete();
            return response()->json([
                'success'      => true,
                'deleteAttendance' => $deleteAttendance,          
            ]);
        }
    }

    public function deleteRequesUndetime($id) {
        $deleteUndertime = UndertimeRequest::findOrFail($id);
        if ($deleteUndertime) {
            $deleteUndertime->delete();
            return response()->json([
                'success'      => true,
                'deleteUndertime' => $deleteUndertime,          
            ]);
        }
    }

}
