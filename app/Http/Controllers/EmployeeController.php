<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Memo;
use App\Models\User;
use App\Models\Asset;
use App\Models\Memos;
use App\Models\DaType;
use App\Models\Salary;
use App\Models\Benefit;
use App\Models\Contact;
use App\Models\Document;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Movement;
use App\Models\Schedule;
use App\Models\Dependent;
use App\Models\Education;
use App\Models\TaxStatus;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\UserLevels;
use App\Models\BenefitType;
use App\Models\Employments;
use App\Models\LeaveCredit;
use App\Models\Requirement;
use App\Models\LeaveRequest;
use App\Models\OffenseLevel;
use App\Models\SalaryAction;
use App\Models\ScheduleType;
use Illuminate\Http\Request;
use App\Models\AssetCategory;
use App\Models\EducationType;
use App\Models\EmployeeEmail;
use App\Models\LeaveSettings;
use App\Models\MedicalRecord;
use App\Models\AssetCondition;
use App\Models\EmployeeRecord;
use App\Models\EmploymentType;
use App\Models\IncidentReport;
use App\Models\OvertimeRequest;
use App\Models\RequirementItem;
use App\Models\EmergencyContact;
use App\Models\EmploymentStatus;
use App\Models\LeaveCreditsSick;
use App\Models\UndertimeRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\LeaveCreditsVacation;
use App\Models\GovernmentInformation;
use App\Models\ScheduleConfiguration;
use App\Models\EmployeeAlternatePhoneNumber;

class EmployeeController extends Controller
{
    public function getEmployeeList()
    {
        $employees = Employee::with([
            'employments' => function ($q) {
                $q->select('*')->with([
                  'user' => function ($q) {
                    $q->select('*')->with([
                      'user_levels' => function ($q) {
                        $q->select('*');
                      }
                    ]);
                  }
                ])->with([
                  'departments' => function ($q) {
                    $q->select('id', 'name')
                    ->with(['leave_credits' => function ($q) {
                      $q->select('*');
                    }
                  ]);
                  }
                ])->with([
                    'locations' => function ($q) {
                      $q->select('id', 'name');
                    }
                  ])->with([
                    'employmentstatus' => function ($q) {
                      $q->select('id', 'name');
                    }
                  ])->with([
                    'schedule_types' => function ($q) {
                      $q->select('id', 'name');
                    }
                  ]);

            }
        ])
        ->with([
            'government' => function($q){
              $q->select('*');
            }
          ])
          ->with([
            'schedule' => function($q){
              $q->select('*');
            }
          ])
          ->with([
            'educations' => function ($q) {
              $q->select('*');
            }
          ])
          ->with([
            'contacts' => function ($q) {
              $q->select('*');
            }
          ])
          ->with([
            'emergency' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'alternate' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'email' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'dependents' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'benefits' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'banks' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'salaries' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'assets' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'memo' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'leave_credits_sick' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'overtime_requests' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'leave_requests' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'undertime_requests' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'incident_reports' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'leave_credits_vacation' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'leave_settings' => function ($q) {
              $q->select('*');
            }
          ])->with(['requirements' => function($q){
          $q->select('*');
          }
          ])->with([
            'employee_rec' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'movements' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'documents' => function ($q) {
              $q->select('*');
            }
          ])->with([
            'medical_record' => function ($q) {
              $q->select('*');
            }
          ])
        ->get();
        return response()->json(['success' => true, 'employees' => $employees], 200);
    }

    public function viewProfileEmployee($id)
    {
      $employees = Employee::where('id', $id)->with([
        'employments' => function ($q) {
            $q->select('*')->with([
              'user' => function ($q) {
                $q->select('*')->with([
                  'user_levels' => function ($q) {
                    $q->select('*');
                  }
                ]);
              }
            ])->with([
              'departments' => function ($q) {
                $q->select('id', 'name')
                ->with(['leave_credits' => function ($q) {
                  $q->select('*');
                }
              ]);
              }
            ])->with([
                'locations' => function ($q) {
                  $q->select('id', 'name');
                }
              ])->with([
                'employmentstatus' => function ($q) {
                  $q->select('id', 'name');
                }
              ])->with([
                'schedule_types' => function ($q) {
                  $q->select('id', 'name');
                }
              ]);

          }
      ])
      ->with([
          'government' => function($q){
            $q->select('*')->with([
              'tax_status' => function($q){
                $q->select('*');
              }
            ]);
          }
        ])
        ->with([
          'schedule' => function($q){
            $q->select('*');
          }
        ])
        ->with([
          'educations' => function ($q) {
            $q->select('*')->with([
              'education_type' => function ($q) {
                $q->select('*');
              }
            ]);
          }
        ])
        ->with([
          'contacts' => function ($q) {
            $q->select('*');
          }
        ])
        ->with([
          'emergency' => function ($q) {
            $q->select('*');
          }
        ])->with([
          'alternate' => function ($q) {
            $q->select('*');
          }
        ])->with([
          'email' => function ($q) {
            $q->select('*');
          }
        ])->with([
          'dependents' => function ($q) {
            $q->select('*');
          }
        ])->with([
          'benefits' => function ($q) {
            $q->select('*')->with([
              'dependents' => function ($q) {
                $q->select('*');
              }
            ]);
          }
        ])->with([
          'banks' => function ($q) {
            $q->select('*');
          }
        ])->with([
          'salaries' => function ($q) {
            $q->select('*')->with([
              'salary_action' => function ($q) {
                $q->select('*');
              }
            ]);
          }
        ])->with([
          'assets' => function ($q) {
            $q->select('*')
            ->with([
              'category_action' => function ($q) {
                $q->select('*');
              }
            ])->with([
              'condition_action' => function ($q) {
                $q->select('*');
              }
            ]);
          }
        ])->with([
          'memo' => function ($q) {
            $q->select('*')->with([
              'offense_level' => function ($q) {
                $q->select('*');
              }
            ])->with([
              'da_Types' => function ($q) {
                $q->select('*');
              }
            ]);
          }
        ])->with([
          'leave_credits_sick' => function ($q) {
            $q->select('*');
          }
        ])->with([
          'leave_credits_vacation' => function ($q) {
            $q->select('*');
          }
        ])->with(['requirements' => function($q){
           $q->select('*');
        }
        ])->with([
          'employee_rec' => function ($q) {
            $q->select('*');
          }
        ])->with([
          'movements' => function ($q) {
            $q->select('*')->with([
              'employment_status' => function ($q) {
                $q->select('*');
              }
            ])->with([
              'employment_type' => function ($q) {
                $q->select('*');
              }
            ]);
          }
        ])->with([
          'documents' => function ($q) {
            $q->select('*');
          }
        ])->with([
          'medical_record' => function ($q) {
            $q->select('*');
          }
        ])
      ->get();
      return response()->json(['success' => true, 'employees' => $employees], 200);
    }

    public function employeedirectorysearch() {
      
      $search = request('query');
      $employee_directory = Employee::select('*')->with(['employments' => function ($q) {
        $q->select('*')->with(['departments' => function ($q) {
          $q->select('*');
        }]);
      }])
        ->whereRaw("concat(first_name, ' ', middle_name, ' ', last_name) like ?", ["%{$search}%"])
        ->orWhere('gender', 'like', "{$search}%")
        ->orWhereHas('employments', function ($q) use ($search) {
          $q->select('*')->where('title', 'like', "%{$search}%")
          ->orWhereHas('departments', function ($q) use ($search) {
            $q->select('*')->where('name', 'like', "%{$search}%");
          });
        })->get();
      return response()->json(['success' => true, 'employee_directory' =>  $employee_directory], 200);
    }


    public function getEmploymentOptions()
    {
      $departments = Department::get();
      $employment_statuses = EmploymentStatus::get();
      $locations = Location::get();
      $schedType = ScheduleType::get();
      $levels = UserLevels::get();
      $tax_statuses = TaxStatus::get();
      $requirements = RequirementItem::get();
      $salary_actions = SalaryAction::get();
      $edu_type = EducationType::get();
      $benefit_types = BenefitType::get();
      $category = AssetCategory::get();
      $condition = AssetCondition::get();
      $employment_types = EmploymentType::get();
      $offense = OffenseLevel:: get();
      $daTypes = DaType::get();

      return response()->json([
        'success'               => true,
        'departments'              => $departments,
        'employment_statuses'     => $employment_statuses,
        'locations'             => $locations,
        'levels'                  => $levels,
        'tax_statuses'              => $tax_statuses,
        'reqs'                   => $requirements,
        'offense'               => $offense,
        'daTypes'               => $daTypes,
        'sched_type'            => $schedType,
        'salary_actions'        => $salary_actions,
        'benefit_types'         => $benefit_types,
        'category'              => $category,
        'condition'             => $condition,
        'edu_type'                 => $edu_type,
        'employment_types'       => $employment_types,
      ], 200);
    }

    //basic employee info
    public function store(Request $request)
    {
        // request()->validate([
        //     'first_name' => 'required',
        //     'middle_name' => 'required',
        //     'last_name' => 'required',
        //     'gender' => 'required',
        //     'civil_status' => 'required',
        //     'birthdate' => 'required',
        //     'employee_id' => 'required',
        //     'department_id' => 'required',
        //     'location_id' => 'required',
        //     'billability' => 'required',
        //     'type' => 'required',
        //     'title' => 'required',
        //     'date_hired' => 'required',
        //     'date_regularization' => 'required',
        //     'status_id' => 'required',
        //     'remarks' => 'required',
        //     'biometric' => 'required',
        //     'payroll_type' => 'required',
        //     'payroll_pie_id' => 'required',
        //     'schedule_type_id' => 'required',
        //     'working_hours' => 'required',
        // ]);

        $users = new User;
        $users->username = $request->first_name . ' ' . $request->last_name;
        $users->email = $request->email;
        $users->level_id = $request->selectedRole;
        $users->account_id = $request->selectedRole;
        $users->password = bcrypt(request('password'));
        $users->save();
        
        //basic info
        $employees = new Employee;
        $employees->user_id = $users->id;
        $employees->first_name = $request->first_name;
        $employees->middle_name = $request->middle_name;
        $employees->last_name = $request->last_name;
        $employees->gender = $request->gender;
        $employees->civil_status = $request->civil_status;
        $employees->birthdate = $request->birthdate;
        $employees->save();


        //work info
        $employments = new Employments;
        $employments->user_id = $users->id;
        $employments->department_id = $request->department;
        $employments->location_id = $request->location;

        // $employments->job_grade = $request->job_grade;
        $employments->employee_id = $employees->id;
        $employments->billability = $request->billability;
        $employments->type = $request->employee_type;
        $employments->title = $request->title;
        $employments->date_hired = $request->hired_date;
        $employments->date_regularization = $request->regularization_date;
        $employments->status_id = $request->employee_status;
        $employments->remarks = $request->employee_remarks;
        $employments->biometric = $request->biometric_id;
        $employments->payroll_type = $request->payroll_type;

        //work schedule
        // $employments->schedule_type_id = $request->schedule_type;
        // $employments->working_hours = $request->hours_work;
        $employments->save();

        //Leave Credits
        $leave_credits = new LeaveCredit;
        $leave_credits->employee_id = $employees->id;
        $leave_credits->department_id = $request->department;
        $leave_credits->user_id = $users->id;
        $leave_credits->sick_leave_credits = 8;
        $leave_credits->vacation_leave_credits = 8;


        $leave_credits->save();
        

        // $leave_credits = new LeaveCreditsSick;
        // $leave_credits->employee_id = $employees->id;
        // $leave_credits->save();
    
        // $leave_credits_vacation = new LeaveCreditsVacation;
        // $leave_credits_vacation->employee_id = $employees->id;
        // $leave_credits_vacation->save();

        return response()->json(['success' => true, $request->all()]);
    }

public function employee_search()
{
    $query = request('employee_name');
    $gender = request('genders');
    $employeesInfotatus = request('employeesInfotatus');
    $department = request('department');
    $position = request('position');
    $sortby_name_depart = request('sortby_name_depart');
    $sortby_asc_desc = request('sortby_asc_desc');

    $employees = Employee::join('employments', 'employees.id', '=', 'employments.employee_id')->with([
      'employments' => function ($q) {
          $q->with([
              'user' => function ($q) {
                  $q->select('*')->with([
                      'user_levels' => function ($q) {
                          $q->select('*');
                      }
                  ]);
              }
          ])->with([
              'departments' => function ($q) {
                  $q->select('id', 'name');
              }
          ])
          ->with([
              'employmentstatus' => function ($q) {
                  $q->select('id', 'name');
              }
          ]);
        }
    ])->when($sortby_name_depart, function ($q) use ($sortby_name_depart, $sortby_asc_desc) {
      if($sortby_name_depart == 'id') {
        $q->orderBy('employments.department_id', $sortby_asc_desc ?? 'asc')->get();
      } elseif ($sortby_name_depart == 'id' ) {
        $q->orderBy('employments.department_id', $sortby_asc_desc ?? 'desc')->get();
      }else {
        $q->orderBy($sortby_name_depart ?? 'first_name', $sortby_asc_desc ?? 'desc');
      }
    })
    ->where(function ($q) use ($query) {
        $q->where('first_name', 'like', "%{$query}%")
            ->orWhere('middle_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%");
    })
    ->when($gender, function ($q, $gender) {
        $q->where('gender', $gender);
    })
    ->when($employeesInfotatus, function ($q) use ($employeesInfotatus) {
        $q->whereHas('employments', function ($q) use ($employeesInfotatus) {
            $q->where('status_id', $employeesInfotatus);
        });
    })
    ->when($department, function ($q, $department) {
        $q->whereHas('employments', function ($q) use ($department) {
            $q->where('department_id', $department);
        });
    })
    ->when($position, function ($q, $position) {
        $q->whereHas('employments', function ($q) use ($position) {
            $q->select('*')
            ->whereHas('user', function ($q) use ($position) {
                $q->where('level_id', $position);
            });
        });
    })
    ->get();

    $count = $employees->count(); // Get the count of the query result

    return response()->json(['success' => true, 'employees' => $employees, 'count' => $count], 200);
}

    
    
    
       


    public function editEmployeeDetails(Request $request, $id)
    {
      $user_id = request('user_id');
      $user = User::where('id', $user_id)->first();
      
      $user->username = request('first_name') . ' ' . request('last_name');
      $user->email = request('email');
      $user->level_id = request('selectedRole');
      $user->account_id = request('selectedRole');
      
      if (request('password')) {
          $user->password = bcrypt(request('password'));
      }
      $user->save();

      $request_em = Employee::find($id);
      $request_em->update([
        'first_name'     => request('first_name'),
        'last_name'      => request('last_name'),
        'middle_name'    => request('middle_name'),
        'gender'        => request('gender'),
        'birthdate'     => request('date_of_birth'),
        'civil_status'  => request('civil_status'),
      ]);

  
      $employment = Employments::where('employee_id', $id);
      $employment->where('employee_id', '=', $id)->update([
          'department_id'       => request('department'),
          'billability'         => request('billability'),
          'type'                => request('employee_type'),
          'title'               => request('title'),
          'remarks'             => request('employee_remarks'),
          'biometric'           => request('biometric_id'),
          'payroll_type'        => request('payroll_type'),
          'date_hired'          => request('hired_date'),
          'date_regularization' => request('regularization_date'),
          'location_id' => request('location'),
          'schedule_type_id' => request('schedule_type'),
          'working_hours' => request('hours_work'),
      ]);
  
      $gov = GovernmentInformation::updateOrCreate(
        ['employee_id' => $id,
        ],
        [
        'user_id'       => $user_id,
        'sss'           => $request->sss,
        'tin'           => $request->tin,
        'phil_health'   => $request->philhealth,
        'pag_ibig'      => $request->pagibig,
        'prc'           => $request->prclicense,
        'passport'      => $request->passport,
        'tax_status_id' => $request->tax_status,
        ]
      );
  
      $salary = Salary::updateOrCreate(
        ['employee_id'       => $id],
        [
          'user_id'                   => $user_id,
          'date_from'                 =>request('dfrom'),
          'base_salary'               =>request('basesalary'),
          'others_type'               =>request('othertype'),
          'other_supplies'            =>request('othersupplies'),
          'monthly_gross'             =>request('monthgross'),
          'percentage_increase'       =>request('percentageincrease'),
          'raise_amount'              =>request('raiseamount'),
          'raise_percentage'          =>request('raise'),
          'commission'                =>request('commission'),
          'salary_action_id'          =>request('actionform'),
          'notes'                     =>request('note'),

          'clothing'                  =>request('clothing'),
          'communication'             =>request('communication'),
          'discretionary'             =>request('discretionary'),
          'laundry'                   =>request('laudry'),
          'meal'                      =>request('meal'),
          'medical'                   =>request('medical'),
          'productivity'              =>request('productivity'),
          'rice'                      =>request('rice'),
          'transportation'            =>request('transportation'),
          'travel'                    =>request('travel'),
          'others'                    =>request('others'),
        ]
        );
  
      $education_data = request('educationData');
      foreach($education_data as $d) {
        $education = Education::updateOrCreate(
          [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $d['ed_id'] !=null ?  $d['ed_id']:null
          ],
          [
            'from'              => $d['datefrom'] !=null ? $d['datefrom']:null,
            'school'            => $d['school'] !=null ?  $d['school']:null,
            'education_type_id' => $d['educational_type'] !=null ?  $d['educational_type']:null,
            'degree'            => $d['degree'] !=null ?  $d['degree']:null,
            'to'                => $d['dateto'] !=null ?  $d['dateto']:null,
          ]
          );
      }

    // 👉 FOR UPDATING OR CREATING THE CONTACTS OF THE EMPLOYEE
    $contacts = $request->input('contact');
    $con = Contact::updateOrCreate(
      [
        'employee_id' => $id,
        'user_id'       => $user_id,
        'id'          => $contacts['e_id']  ?? null
      ],
      [
        'local_trunk_line' => $contacts['local_trunk_line'] ?? null,
        'pin' => $contacts['pin'] ?? null,
        'skype_id' => $contacts['skype_id'] ?? null
      ]
    ); // $contacts = $request->input('contact');

    // 👉 FOR UPDATING OR CREATING THE EMERGENCY CONTACT OF THE EMPLOYEE
    $emergencyContactsData = request('emergencyContactsData');
    foreach ($emergencyContactsData as $e_item) {
      $e_contact = EmergencyContact::updateOrCreate(
        [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $e_item['id']  ?? null
        ],
        [
          'phone'              => $e_item['emergency_phone_no']   ?? null,
          'relationship'       => $e_item['emergency_relationship']   ?? null,
          'address'            => $e_item['emergency_address']   ?? null,
          'name'               => $e_item['emergency_contact_person']   ?? null,
        ]
      );
    } //foreach ($emergencyContactsData as $e_item)

    // 👉 FOR UPDATING OR CREATING THE ALTERNATE CONTACT OF THE EMPLOYEE
    $alternativeContact = request('alternativeContact');
    foreach ($alternativeContact as $a_item) {
      $alternate_contact = EmployeeAlternatePhoneNumber::updateOrCreate(
        [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $a_item['id']  ?? null
        ],
        [
          'title_id'              => $a_item['alternate_phone_title']   ?? null,
          'phone_number'          => $a_item['alternate_phone_number'] ?? null,
          'contact_person'        => $a_item['alternate_contact_person'] ?? null,
        ]
      );
    } //👉foreach ( $alternativeContact as $a_item)

    // 👉 FOR UPDATING OR CREATING THE ALTERNATE EMAIL OF THE EMPLOYEE
    $alternateEmail = request('alternativeEmails');
    foreach ($alternateEmail as $a_email) {
      $alter_email = EmployeeEmail::updateOrCreate(
        [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $a_email['id']  ?? null,
        ],
        [
          'email'                 => $a_email['email'] ?? null,
          'primary'               => $a_email['primary'] ?? 0,
        ]
      );
    } // 👉 foreach( $alternateEmail as $a_email)
  
      $dependents_data = request('dependentsData');
      foreach($dependents_data as $dependent) {
        $dependents = Dependent::updateOrCreate(
          [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $dependent['dependent_id'] !=null ?  $dependent['dependent_id']:null
          ],
          [
            'first_name'            => $dependent['dependents_firstname'] !=null ? $dependent['dependents_firstname']:null,
            'last_name'             => $dependent['dependents_lastname'] !=null ?  $dependent['dependents_lastname']:null,
            'middle_name'           => $dependent['dependents_middlename'] !=null ?  $dependent['dependents_middlename']:null,
            'relationship'          => $dependent['dependents_relationship'] !=null ?  $dependent['dependents_relationship']:null,
            'birthdate'             => $dependent['dependents_birthdate'] !=null ?  $dependent['dependents_birthdate']:null,
            'gender'                => $dependent['dependents_gender'] !=null ?  $dependent['dependents_gender']:null,
            'notes'                 => $dependent['dependents_note'] !=null ?  $dependent['dependents_note']:null,
          ]
          );
      }
  
      $benefits_data = request('benefitsData');
      foreach($benefits_data as $benefit) {
  
        if ($benefit['active_status']) {
          $active_status = 1;
        } else {
          $active_status = 0;
        }
  
        $benefits = Benefit::updateOrCreate(
          [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $benefit['id'] !=null ?  $benefit['id']:null
          ],
          [
            'benefit_type_id'       => $benefit['benefit'] !=null ? $benefit['benefit']:null,
            'active'                => $active_status,
            'effective_date'        => $benefit['effective_date'] !=null ?  $benefit['effective_date']:null,
            'enrollment_date'       => $benefit['enrollment_date'] !=null ?  $benefit['enrollment_date']:null,
            'plan'                  => $benefit['plan'] !=null ?  $benefit['plan']:null,
            'beneficiary'           => $benefit['beneficiary'] !=null ?  $benefit['beneficiary']:null,
            'notes'                 => $benefit['notes'] !=null ?  $benefit['notes']:null,
            'payment_type'          => $benefit['payment_type'] !=null ?  $benefit['payment_type']:null,
          ]
          );
      }
  
      $banks_data = request('banksData');
      foreach($banks_data as $bank) {
        $banks = Bank::updateOrCreate(
          [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $bank['id'] !=null ?  $bank['id']:null
          ],
          [
            'name'                => $bank['bank_name'] !=null ? $bank['bank_name']:null,
            'account_number'      => $bank['bank_account_no'] !=null ? $bank['bank_account_no']:null,
          ]
          );
      }
  
      $assets_data = request('assetsData');
      foreach($assets_data as $asset) {
        $assets = Asset::updateOrCreate(
          [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $asset['id'] !=null ?  $asset['id']:null
          ],
          [
            'item'                  => $asset['item'] !=null ? $asset['item']:null,
            'category_id'           => $asset['category'] !=null ? $asset['category']:null,
            'condition_id'          => $asset['condition'] !=null ? $asset['condition']:null,
            'price'                 => $asset['purchase_price'] !=null ? $asset['purchase_price']:null,
            'serial_number'         => $asset['serial_no'] !=null ? $asset['serial_no']:null,
            'date_acquired'         => $asset['date_acquired'] !=null ? $asset['date_acquired']:null,
            'date_issued'           => $asset['date_used'] !=null ? $asset['date_used']:null,
            'date_returned'         => $asset['date_returned'] !=null ? $asset['date_returned']:null,
            'notes'                 => $asset['notes'] !=null ? $asset['notes']:null,
          ]
          );
      }

      // 👉 FOR UPDATING OR CREATING THE MEMO OF THE EMPLOYEE
      $memo = request('memoData');
      foreach ($memo as $m_item) {
        $memoData = Memos::updateOrCreate(
          [
            'employee_id'   => $id,
            'user_id'       => $user_id,
            'id'            => $m_item['id']  ?? null,
          ],
          [
            'offense_level' => $m_item['offense_level'] ?? null,
            'da_types'      => $m_item['da_type'] ?? null,
            'memo_subject'  => $m_item['violation_category'] ?? null,
            'slide_date'    => $m_item['served_recieved_date'] ?? null,
            'memo_date'     => $m_item['slide_date'] ?? null,
            'memo_note'     => $m_item['notes'] ?? null
          ]
        );
      } //👉 foreach($memo as $m_item)
  

    // 👉 FOR UPDATING OR CREATING THE LEAVE CREDITS(SICK) OF THE EMPLOYEE
    $sickCredits = request('creditsSick');
    $name = 'Sick';
    $c_user = LeaveCredit::select('sick_leave_credits')
      ->where('employee_id', '=', $id)
      ->first(); // use first() instead of get() to retrieve a single result
    if ($sickCredits['ac'] ?? 0) {
      if (intval($c_user->sick_leave_credits) >= 0 && $sickCredits['ac'] == 4) {
        $ac = $sickCredits['ac'];
        $dataCredits = $c_user->sick_leave_credits + $ac;
      } else if (intval($c_user->sick_leave_credits) > 0  && $sickCredits['ac'] == -4) {
        $ac = $sickCredits['ac'];
        $dataCredits = $c_user->sick_leave_credits + $ac;
      } else {
        return response()->json(['success' => false], 422);
      }

      $sick = LeaveCredit::updateOrCreate(
        [
          'employee_id'  => $id,
          'user_id'       => $user_id,
          'id'           => $sickCredits['l_id'] ?? null
        ],
        [
          'name'         => $name,
          'sick_leave_credits'      => $dataCredits,
          'reasons'      => $sickCredits['rs'] ?? null
        ]
      );
    } //👉if($sickCredits['ac'])

    // 👉 FOR UPDATING OR CREATING THE LEAVE CREDITS(VACATION) OF THE EMPLOYEE
    $vacationCredits = request('creditVacation');
    $names = 'Vacation';
    $c_vacation = LeaveCredit::select('vacation_leave_credits')
      ->where('employee_id', '=', $id)
      ->first(); // use first() instead of get() to retrieve a single result
      if ($vacationCredits['v_id'] ?? 0) {
        if (intval( $c_vacation->vacation_leave_credits) >= 0 && $vacationCredits['ad'] == 4) {
          $cv = $vacationCredits['ad'];
          $dataCreditsVacation =  $c_vacation->vacation_leave_credits + $cv;

        } else if (intval( $c_vacation->vacation_leave_credits) > 0  && $vacationCredits['ad'] == -4) {
          $cv = $vacationCredits['ad'];
          $dataCreditsVacation =  $c_vacation->vacation_leave_credits + $cv;
        } else {
          return response()->json(['success' => false], 422);
        }

        $sick = LeaveCredit::updateOrCreate(
          [
            'employee_id'  => $id,
            'user_id'       => $user_id,
            'id'           => $vacationCredits['v_id'] ?? null
          ],
          [
            'name'         => $names,
            'vacation_leave_credits'      => $dataCreditsVacation,
            'reasons'      => $vacationCredits['rs'] ?? null
          ]
        );
      }//👉 if ($vacationCredits['v_id'] ?? 0)

      $requirement = request('requirements');
      foreach ($requirement as $row){

      $req = Requirement::updateOrCreate(
        [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $row['req_id'] ?? null
        ],[
          'requirement_name' => $row['name'] ?? null,
          'notes'                  => $row['notes'] ?? null,
          'completed'             => $row['selectedCheckbox'] ?? 0
        ]
      );

     }


      $employments_data = request('employeeRecords');
      foreach($employments_data as $em_rec) {
        $employments_rec = EmployeeRecord::updateOrCreate(
          [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $em_rec['id'] !=null ?  $em_rec['id']:null
          ],
          [
            'position'              => $em_rec['position'] !=null ? $em_rec['position']:null,
            'company'               => $em_rec['company'] !=null ? $em_rec['company']:null,
            'industry'              => $em_rec['industry'] !=null ? $em_rec['industry']:null,
            'from'                  => $em_rec['from'] !=null ? $em_rec['from']:null,
            'to'                    => $em_rec['to'] !=null ? $em_rec['to']:null,
          ]
          );
      }

      $documents_data = request('documentData');
      foreach($documents_data as $docs_rec) {
        $documents_rec = Document::updateOrCreate(
          [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $docs_rec['id'] !=null ?  $docs_rec['id']:null
          ],
          [
            'file_name'              => $docs_rec['file_name'] !=null ? $docs_rec['file_name']:null,
            'creation_time'               => $docs_rec['creation_time'] !=null ? $docs_rec['creation_time']:null,
          ]
          );
      }

      $medical_data = request('medicalData');
      foreach($medical_data as $med_rec) {
        $medical_rec = MedicalRecord::updateOrCreate(
          [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $med_rec['id'] !=null ?  $med_rec['id']:null
          ],
          [
            'file_name'              => $med_rec['file_name'] !=null ? $med_rec['file_name']:null,
            'creation_time'               => $med_rec['creation_time'] !=null ? $med_rec['creation_time']:null,
            'classification'               => $med_rec['classification'] !=null ? $med_rec['classification']:null,
            'notes'               => $med_rec['notes'] !=null ? $med_rec['notes']:null,
          ]
          );
      }
  
      $movements_data = request('movementsData');
      foreach($movements_data  as $movement) {
        $movementsData = Movement::updateOrCreate(
          [
          'employee_id'   => $id,
          'user_id'       => $user_id,
          'id'            => $movement['id'] !=null ?  $movement['id']:null
          ],
          [
            'date_from'                     => $movement['date_from'] !=null ? $movement['date_from']:null,
            'date_to'                       => $movement['date_to'] !=null ? $movement['date_to']:null,
            'from_position'                 => $movement['from_position'] !=null ? $movement['from_position']:null,
            'from_department'               => $movement['from_department'] !=null ? $movement['from_department']:null,
            'from_employment_type_id'       => $movement['from_employment_type_id'] !=null ? $movement['from_employment_type_id']:null,
            'from_employment_status_id'     => $movement['from_employment_status_id'] !=null ? $movement['from_employment_status_id']:null,
            'to_position'                   => $movement['to_position'] !=null ? $movement['to_position']:null,
            'to_department'                 => $movement['to_department'] !=null ? $movement['to_department']:null,
            'to_employment_type_id'         => $movement['to_employment_type_id'] !=null ? $movement['to_employment_type_id']:null,
            'to_employment_status_id'       => $movement['to_employment_status_id'] !=null ? $movement['to_employment_status_id']:null,
            'action_for'                    => $movement['action_for'] !=null ? $movement['action_for']:null,
            'notes'                         => $movement['notes'] !=null ? $movement['notes']:null,
          ]
          );
      }
  
    $sched_data = request('scheduledata');
        foreach($sched_data  as $item) {
        $sched_d = Schedule::updateOrCreate(
        [
        'employee_id'   => $id,
        'user_id'       => $user_id,
        'id'            => $item['sched_id'] ?? null
        ],
        [
            'day'                   => $item['day'] ?? null,
            'shift_start'           => $item['shift_start'] ?? null,
            'shift_end'             => $item['shift_end'] ?? null,
            'break_start'           => $item['break_start'] ?? null,
            'break_end'             => $item['break_end'] ?? null,
            'rest_day'              => $item['rest_day'] ?? 0,
        ]
        );
    }
  
      return response()->json([
        'success'             => true, $request->all()
      ]);
    }

    public function editScheduleConfig(Request $request, $id) {
      $sched_config = request('scheduleconfig');
      foreach($sched_config  as $item) {
      $sched_d = ScheduleConfiguration::updateOrCreate(
      [
      'schedule_type_id' => $id,
      'id' => $item['sched_id'] ?? null,
      ],
      [
          'day'                   => $item['day'] ?? null,
          'shift_start'           => $item['shift_start'] ?? null,
          'shift_end'             => $item['shift_end'] ?? null,
          'break_start'           => $item['break_start'] ?? null,
          'break_end'             => $item['break_end'] ?? null,
          'rest_day'              => $item['rest_day'] ?? 0,
      ]
      );
    }
      return response()->json([
        'success'             => true, 'sched_config' => $sched_config
      ]);
    }

    public function scheduleConfiguration()
    {
        $schedule_config = ScheduleConfiguration::with([
            'scheduletypes' => function ($query) {
                $query->select('id');
            }
        ])->get();

        foreach ($schedule_config as $row) {
          $data[$row->schedule_type_id][] = [$row];
      }

        return response()->json(['success' => true, 'data' => $data,'schedule_config' => $schedule_config]);
    }

    public function deleteItemInfo($id) {

      $deleteEduRow = Education::find($id);
      $deleteEmergencyContact =   EmergencyContact::find($id);
      $deleteAlternatePhoneNum = EmployeeAlternatePhoneNumber::find($id);
      $deleteEmployeeEmail = EmployeeEmail::find($id);
      $deleteDependentsRow = Dependent::find($id);
      $deleteAssetsRow = Asset::find($id);
      $deleteBankRow = Bank::find($id);
      $deleteEmployeeRow = EmployeeRecord::find($id);
      $deleteBenefitsRow = Benefit::find($id);
      $deleteMovementsRow = Movement::find($id);
      $deleteMemoRow = Memos::find($id);
      $deleteDocumentsRow = Document::find($id);
      $deleteMedicalRow = MedicalRecord::find($id);

      
  
      if($deleteEduRow){
          $deleteEduRow->delete();
          return response()->json([
            'success'                     => true,
            'deleteRow'                   => $deleteEduRow,
            'message'                     => 'Row with ID ' . $id . ' deleted from Educations table.'
          ]);
      }elseif($deleteEmergencyContact) {
        $deleteEmergencyContact->delete();
        return response()->json([
          'success'                     => true,
          'deleteRow'                   => $deleteEmergencyContact,
          'message'                     => 'Row with ID ' . $id . ' deleted from Emergency Contact table.'
        ]);
      }elseif($deleteAlternatePhoneNum) {
        $deleteAlternatePhoneNum->delete();
        return response()->json([
          'success'                     => true,
          'deleteRow'                   => $deleteAlternatePhoneNum,
          'message'                     => 'Row with ID ' . $id . ' deleted from Alternate Phone Number table.'
        ]);
      }elseif($deleteEmployeeEmail) {
        $deleteEmployeeEmail->delete();
        return response()->json([
          'success'                     => true,
          'deleteRow'                   => $deleteEmployeeEmail,
          'message'                     => 'Row with ID ' . $id . ' deleted from Employee Email table.'
        ]);
      }elseif($deleteDependentsRow){
          $deleteDependentsRow->delete();
          return response()->json([
            'success'                     => true,
            'deleteRow'                   => $deleteDependentsRow,
            'message'                     => 'Row with ID ' . $id . ' deleted from Dependents table.'
          ]);
      }elseif($deleteBenefitsRow){
        $deleteBenefitsRow->delete();
        return response()->json([
          'success'                     => true,
          'deleteRow'                   => $deleteBenefitsRow,
          'message'                     => 'Row with ID ' . $id . ' deleted from Benefits table.'
        ]);
      }elseif($deleteAssetsRow){
        $deleteAssetsRow->delete();
        return response()->json([
          'success'                     => true,
          'deleteRow'                   => $deleteAssetsRow,
          'message'                     => 'Row with ID ' . $id . ' deleted from Assets table.'
        ]);
      }elseif($deleteBankRow){
        $deleteBankRow->delete();
        return response()->json([
          'success'                     => true,
          'deleteRow'                   => $deleteBankRow,
          'message'                     => 'Row with ID ' . $id . ' deleted from Banks table.'
        ]);
      }elseif($deleteEmployeeRow){
        $deleteEmployeeRow->delete();
        return response()->json([
          'success'                     => true,
          'deleteRow'                   => $deleteEmployeeRow,
          'message'                     => 'Row with ID ' . $id . ' deleted from Employee Records table.'
        ]);
      } elseif($deleteMovementsRow){
        $deleteMovementsRow->delete();
        return response()->json([
          'success'                     => true,
          'deleteRow'                   => $deleteMovementsRow,
          'message'                     => 'Row with ID ' . $id . ' deleted from Movement table.'
        ]);
      }elseif($deleteMemoRow){
        $deleteMemoRow->delete();
        return response()->json([
          'success'                     => true,
          'deleteRow'                   => $deleteMemoRow,
          'message'                     => 'Row with ID ' . $id . ' deleted from Memo table.'
        ]);
        }elseif($deleteDocumentsRow){
          $deleteDocumentsRow->delete();
          return response()->json([
            'success'                     => true,
            'deleteRow'                   => $deleteDocumentsRow,
            'message'                     => 'Row with ID ' . $id . ' deleted from Memo table.'
          ]);
          }elseif($deleteMedicalRow){
            $deleteMedicalRow->delete();
            return response()->json([
              'success'                     => true,
              'deleteRow'                   => $deleteMedicalRow,
              'message'                     => 'Row with ID ' . $id . ' deleted from Memo table.'
            ]);
            }
        
        else{
            return response()->json([
              'success'                     => false,
              'message'                     => 'No row with ID ' . $id . ' found in either table.',
            ]);
        }
    }

    //Schedule Controller
    public function viewSchedule()
    {
        $schedules =Schedule::all();
        return response()->json(['success' => true, 'schedules' => $schedules]);
    }

    //crud view schedule
    public function getScheduleCategories() {
        $schedule_categories = ScheduleType::all();
        return response() -> json(['success' => true, 'schedule_categories' => $schedule_categories]);
    }

    public function GetID_scheduletype($id)
    {
        $getID = ScheduleType::findOrFail($id);
        return response()->json(['success' => true, 'getID' => $getID],200);
    }

    //scheduleConfig
    public function scheduleConfig()
    {
        $schedule_configuration = ScheduleConfiguration::with([
            'scheduletypes' => function ($query) {
                $query->select('id');
            }
        ])->get();
        
        foreach ($schedule_configuration as $row) {
            $data[$row->schedule_type_id][] = [$row];
        }

        return response()->json(['success' => true, 'data' => $data, 'schedule_configuration' => $schedule_configuration,]);
    }
    
    //crud shift schedule create
    public function storeScheduleCategories()
    {
        // Use camelCase for method names and capitalize the first letter of each word
        request()->validate([
            'name' => 'required',
        ]);
    
        $scheduleType = ScheduleType::create([
            'name' => request('name'),
        ]);
    
        $scheduleConfig = request()->input('scheduleconfig'); // Use input() instead of request() to get input data

        foreach ($scheduleConfig as  $row) {
          $scheduleConfiguration = ScheduleConfiguration::create([
              'schedule_type_id' => $scheduleType->id,
              'day' => $row['days']  ?? null,
              'shift_start' => $row['shift_start'] ?? null,
              'shift_end' => $row['shift_end'] ?? null,
              'break_start' => $row['break_start'] ?? null,
              'break_end' => $row['break_end'] ?? null,
              'rest_day' => $row['rest_day'] ?? 0,
          ]);
      }

        // Use snake_case for array keys
        return response()->json([
            'success' => true,
            'scheduleConfig' => $scheduleConfig,
            'schedule_type' => $scheduleType,
        ]);
    }
    
    //update schedule
    public function updateScheduleCategory($id) {
        request()->validate([
            'name' => 'required',
        ]);
        $schedule_update= ScheduleType::updateOrCreate([
            'id' => $id
        ],[
            'name' => request('name'),
        ]);
        return response() -> json(['success' => true, 'schedule_update' => $schedule_update]);
    }
    //delete schedule
    public function DeleteScheduleCategory($id) {
        
        $schedule_delete= ScheduleType::findOrFail($id);
        $schedule_delete->delete();

        $schedule_config= ScheduleConfiguration::where('schedule_type_id', $schedule_delete->id);
        $schedule_config->delete();
        
        return response()->json(['success' => true, 'schedule_config' => $schedule_config, 'schedule_delete' => $schedule_delete]);
    }
    //view schedule
    public function ViewScheduleCategory($id){

        $schedule_view = ScheduleType::find($id);
        return response()->json(['success' => true, 'schedule_view' => $schedule_view]);
    }
    
     //Tax Status Controller
     public function viewTaxStatus()
     {
         $tax_statuses =TaxStatus::all();
         return response()->json($tax_statuses);
     }
     //Memo Controller
     public function getMemo() {
        $memo_view = Memo::all();
        return response() -> json(['success' => true, 'memo_view' => $memo_view]);
    }
    //Memo Create
    public function Creatememo()
    {
        request() ->validate([
            'to_address' => 'required',
            'from_address' => 'required',
            'memo_subject' => 'required',
            'memo_date' => 'required',
            'memo_message' => 'required',
        ]);
        $memo_create= Memo::updateOrCreate([
            'to_address' => request('to_address'),
            'from_address' => request('from_address'),
            'memo_subject' => request('memo_subject'),
            'memo_date' => request('memo_date'),
            'memo_message' => request('memo_message'),
        ]);
        return response()->json(['success' => true, 'memo_create' => $memo_create]);
    }
    //memo search
    public function searchRequestMemo()
    {
        $searchRequestMemo = request('query');

        $searchResults = Memo::where(function ($query) use ($searchRequestMemo) {
            $query->where('to_address', 'like', '%' . $searchRequestMemo . '%')
                ->orWhere('from_address', 'like', '%' . $searchRequestMemo . '%')
                ->orWhere('memo_subject', 'like', '%' . $searchRequestMemo . '%')
                ->orWhere('memo_date', 'like', '%' . $searchRequestMemo . '%');
        })->get(['to_address', 'from_address', 'memo_subject', 'memo_date']);
        
        return response()->json($searchResults);
    }   

    public function MemoRangeSearch() {
      $startDate = request('startDate');
      $endDate = request('endDate');
    
      $memoData = Memo::whereBetween('to_address', [$startDate, $endDate])
        ->orWhereBetween('from_address', [$startDate, $endDate])
        ->orWhereBetween('memo_subject', [$startDate, $endDate])
        ->orWhereBetween('memo_date', [$startDate, $endDate])
        ->latest()
        ->get();
      return response()->json(['success' => true, 'memoData' => $memoData], 200);
    }

    //update memo
    public function updateMemo($id)
    {
        request()->validate([
            'to_address' => 'required',
            'from_address' => 'required',
            'memo_subject' => 'required',
            'memo_date' => 'required',
            'memo_message' => 'required',
        ]);
        $memo_update= Memo::updateOrCreate([
            'id' => $id
        ],[
            'to_address' => request('to_address'),
            'from_address' => request('from_address'),
            'memo_subject' => request('memo_subject'),
            'memo_date' => request('memo_date'),
            'memo_message' => request('memo_message'),
        ]);
        return response() -> json(['success' => true, 'memo_update' => $memo_update]);
    }
    //delete memo
    public function DeleteMemo($id) {
        $memo_delete= Memo::findOrFail($id);
        $memo_delete->delete(); 
        return response()->json(['success' => true, 'memo_delete' => $memo_delete]);
    }
    public function ViewMemo($id){
        $memo_view = Memo::find($id);
        return response()->json(['success' => true, 'memo_view' => $memo_view]);
    }

  //attendance Controller
  public function getAttendance()
  {
    $attendance_view = Employee::with([
      'attendance_logs' => function ($q) {
        $q->select('*');
      }
    ])->latest()->get();
    return response()->json(['success' => true, 'attendance_view' => $attendance_view], 200);
  } // public function getAttendance()

  public function getSpecificAttendanceData()
  {
    $attendanceLogs = Attendance::where('status_id', '=', 'Approved')
    ->with(['employee' => function ($q) {
      $q->select('*', DB::raw('TIMEDIFF(timeOut, timeIn) as totalHours'))->latest();
    }])->get(); 
    return response()->json(['success' => true, 'attendanceLogs' => $attendanceLogs], 200);
  } // public function getSpecificAttendanceData()
  
//Attendance add datas
public function storeData(Request $request)
{
  $dataValues = request('dataValues');
  // return response()->json([ 
  //   'dataValues'  => $dataValues,
  // ]);

  if ($dataValues['attendanceId'] ?? null != null) {
    $id = $dataValues['attendanceId'];
    $dataLogin = Attendance::select('login')->where('id', '=', $id)->get()->first();
    $dataTimeIn = Attendance::select('timeIn')->where('id', '=', $id)->get()->first();
    $logout = $dataValues['attendance_date'];
    
    $data = Attendance::updateOrCreate(
      [
        'id' =>  $dataValues['attendanceId'] ?? null,
        'employee_id' => $dataValues['emplist'] ?? null,
      ],
      [
        'user_id'     => $dataValues['user_id'] ?? null,
        'login'       => $dataLogin['login'],
        'timeIn'      => $dataTimeIn['timeIn'],
        'state'       => $dataValues['state'] ?? null,
        'logout'      => $logout,
        'timeOut'     => $dataValues['attendance_time'] ?? null,

      ]
    );

    return response()->json(['success' => true, $request->all()]);
  } else {

    $data = Attendance::updateOrCreate(
      [
        'id' =>  $dataValues['attendanceId'] ?? null,
        'employee_id' => $dataValues['emplist'] ?? null,
      ],
      [
        'user_id'     => $dataValues['user_id'] ?? null,
        'login'       => $dataValues['attendance_date'],
        'timeIn'      => $dataValues['attendance_time'] ?? null,
        'state'       => $dataValues['state'] ?? null,
      ]
    );
    return response()->json(['success' => true, $request->all()]);
  } // public function store data()
}
public function editAttendance(Request $request, $id)
{
  $editAttendance = Attendance::updateOrCreate(
    [
      'id'          => $id,
      'employee_id' => request('emplist'),
    ],
    [
      'login'       => request('attendance_date'),
      'timeIn'      => request('attendance_time'),
      'logout'      => request('attendance_dateOut'),
      'timeOut'     => request('attendance_timeOut'),
      'state'       => request('state'),
    ]
  );
  return response()->json(['success' => true, $request->all()]);
} // public function editEmployeeLogs()

public function rangeSearch()
{
  $startDate = request('startDate');
  $endDate = request('endDate');

  $attendanceLogs = Attendance::with(['employee'])
    ->select('*', DB::raw('TIMEDIFF(timeOut, timeIn) as totalHours'))
    ->whereBetween('login', [$startDate, $endDate])
    ->orWhereBetween('logout', [$startDate, $endDate])
    ->latest()
    ->get();
  return response()->json(['success' => true, 'attendanceLogs' => $attendanceLogs], 200);
} // public function attendance rangeSearch()
public function Search()
{
  $search = request('dataSearch');
  $attendanceLogs = Attendance::with(['employee'])
    ->select('*', DB::raw('TIMEDIFF(timeOut, timeIn) as totalHours'))
    ->where('login', 'like', "%{$search}%")
    ->orWhere('logout', 'like', "%{$search}%")
    ->orWhereHas('employee', function ($q) use ($search) {
      $q->whereRaw("concat(first_name, ' ', middle_name, ' ', last_name) like ?", ["%{$search}%"]);
    })
    ->latest()
    ->get();
  return response()->json(['success' => true, 'attendanceLogs' => $attendanceLogs], 200);
} //  public function search()

//EmployeeList Search
public function listSearch()
{
  $search = request('query');
  $employees = Employee::select('*')->with(['employments' => function ($q) {
    $q->select('*')->with(['employmentstatus' => function ($q) {
      $q->select('*');
    }])->with(['departments' => function ($q) {
      $q->select('*');
    }]);
  }])
    ->whereRaw("concat(first_name, ' ', middle_name, ' ', last_name) like ?", ["%{$search}%"])
    ->orWhereHas('employments', function ($q) use ($search) {
      $q->select('*')->where('date_hired', 'like', "%{$search}%");
    })->orWhereHas('employments', function ($q) use ($search) {
      $q->select('*')->where('date_regularization', 'like', "%{$search}%");
    })->orWhereHas('employments', function ($q) use ($search) {
      $q->select('*')->where('title', 'like', "%{$search}%")->orWhereHas('employmentstatus', function ($q) use ($search) {
        $q->select('*')->where('name', 'like', "%{$search}%");
      })->orWhereHas('departments', function ($q) use ($search) {
        $q->select('*')->where('name', 'like', "%{$search}%");
      });
    })->get();
  return response()->json(['success' => true, 'employees' => $employees], 200);
} // public function EmploymentSearch()

//overtime request
public function overtimeRequest()
{
  $overtime = OvertimeRequest::where('status_id', '=', 'Approved')
    ->with(['employee' => function ($q) {
      $q->select('*');
    }])->get();
  return response()->json(['success' => true, 'overtime' => $overtime], 200);
} // public function getovertimeRequest()

//OvertimeList Search
public function overtimelistSearch()
{
    $search = request('query');
    $overtimeSearch = OvertimeRequest::with('employee')
    ->select('*')
      ->where(function ($query) use ($search) {
        $query->where('day', 'like', "%{$search}%")
          ->orWhere('shift_date', 'like', "%{$search}%")
          ->orWhere('shift_from', 'like', "%{$search}%")
          ->orWhere('shift_to', 'like', "%{$search}%")
          ->orWhere('start', 'like', "%{$search}%")
          ->orWhere('end', 'like', "%{$search}%")
          ->orWhere('updated_at', 'like', "%{$search}%")
          ->orWhereHas('employee', function ($query) use ($search) {
            $query->whereRaw("concat(first_name, ' ', middle_name, ' ', last_name) like ?", ["%{$search}%"]);
          });
      })
      ->get();

    return response()->json(['success' => true, 'overtimeSearch' => $overtimeSearch], 200);
}// public function OvertimeSearch()

public function OvertimerangeSearch()
{
  $startDate = request('startDate');
  $endDate = request('endDate');

  $overtimeRange = OvertimeRequest::with(['employee'])
    ->whereBetween('shift_date', [$startDate, $endDate])
    ->orWhereBetween('updated_at', [$startDate, $endDate])
    ->latest()
    ->get();

  return response()->json(['success' => true, 'overtimeRange' => $overtimeRange], 200);
} // public function OvertimerangeSearch()

public function undertimeRequest()
{
  $undertime = UndertimeRequest::where('status_id', '=', 'Approved')
    ->with(['employee' => function ($q) {
      $q->select('*');
    }])->get();
  return response()->json(['success' => true, 'undertime' => $undertime], 200);
} // public function getUndertimeRequest()

public function undertimeSearch()
{
  $search = request('query');
  $undertimesearch = UndertimeRequest::select('*')->with(['employee' => function ($q) {
    $q->select('*');
  }])
    ->where('date_req', 'like', "%{$search}%")
    ->orWhere('from', 'like', "%{$search}%")
    ->orWhere('to', 'like', "%{$search}%")
    ->orWhere('updated_at', 'like', "%{$search}%")
    ->orWhereHas('employee', function ($q) use ($search) {
      $q->select('*')->whereRaw("concat(first_name, ' ', middle_name, ' ', last_name) like ?", ["%{$search}%"]);
    })
    ->get();
  return response()->json(['success' => true, 'undertimesearch' => $undertimesearch], 200);
} //   public function searchUndertime()

public function UndertimerangeSearch()
{
  $startDate = request('startDate');
  $endDate = request('endDate');

  $undertimeRange = UndertimeRequest::with(['employee'])
    ->whereBetween('date_req', [$startDate, $endDate])
    ->orWhereBetween('updated_at', [$startDate, $endDate])
    ->latest()
    ->get();
  return response()->json(['success' => true, 'undertimeRange' => $undertimeRange], 200);
} // public function rangeSearch()

public function leaveRequest()
{
  $leave = LeaveRequest::select('*', DB::raw('DATEDIFF(date_to, date_from) as leaveDays'))->where('status_id', '=', 'Approved')
    ->with(['employee' => function ($q) {
      $q->select('*')->with(['employments' => function ($q) {
        $q->select('*')->with(['departments' => function ($q) {
          $q->select('*');
        }]);
      }]);
    }])->get();

  return response()->json(['success' => true, 'leave' => $leave], 200);
} // public function getLeaveRequest()

public function leaveSettingData()
{
  $leavesettings = LeaveSettings::
    with(['employee' => function ($q) {
      $q->with(['user_levels' => function ($q) {
          $q->select('*');
        }]);
    }])->get();
  return response()->json(['success' => true, 'leavesettings' => $leavesettings], 200);
} // public function getovertimeRequest()

public function leaveSearchRange()
{
    $startDate = request('startDate');
    $endDate = request('endDate');

    $leaveRange = LeaveRequest::select('*', DB::raw('DATEDIFF(date_to , date_from) as leaveDays'))
    ->where(function ($q) use ($startDate, $endDate) {
      $q->whereBetween('date_from', [$startDate, $endDate])
        ->orWhereBetween('date_to', [$startDate, $endDate]);
    })->with(['employee' => function ($q) {
        $q->with(['employments' => function ($q)  {
          $q->with(['departments' => function ($q) {
            $q->select('*');
          }]);
      }]);
      }])->get();
    return response()->json(['success' => true, 'leaveRange' => $leaveRange], 200);
}

//incident report
public function storeIncident(Request $request)
{
    // request()->validate([
    //     'selectEmployee'   => 'required',
    //     'account'          => 'required',
    //     'teamLeader'       => 'required',
    //     'incident'         => 'required',
    //     'dateTime'         => 'required',
    //     'offenseLevel'     => 'required'
    // ]);
    $incident = new IncidentReport;
    $incident->employee_id = $request->selectEmployee;
    $incident->offense_level_id = $request->offenseLevel;
    $incident->account = $request->account;
    $incident->immediate_head = $request->teamLeader;
    $incident->incident = $request->incident;
    $incident->dt_of_incident = $request->dateTime;
    $incident->save();

    return response()->json(['success' => true, 'incident' => $incident], 200);
} // public function storeIncident(Request $request)

//leavesetting Create
public function LeaveSettingsStore()
{
  $dataValues = request('dataValues');
    $leave_create= LeaveSettings::updateOrCreate([
        'leave_count' => $dataValues['leave_count'],
        'user_level' => $dataValues['user_level'],
        'description' =>  $dataValues['description'],
    ]);
    return response()->json(['success' => true, 'leave_create' => $leave_create]);
}

public function editLeaveSettings(Request $request, $id)
{
  $editLeaveSettings = LeaveSettings::updateOrCreate(
    [
      'id'          => $id,
    ],
    [
      'leave_count'       => request('leave_count'),
      'user_level'      => request('user_level'),
      'description'      => request('description'),
    ]
  );
  return response()->json(['success' => true, $request->all()]);
} // public function editLeaveLogs()

//delete leave-settings
public function DeleteLeave($id) {
  $leave_delete= LeaveSettings::findOrFail($id);
  $leave_delete->delete(); 
  return response()->json(['success' => true, 'leave_delete' => $leave_delete]);
}
public function ViewLeave($id){
  $leave_view = LeaveSettings::find($id);
  return response()->json(['success' => true, 'leave_view' => $leave_view]);
}

public function getEmployeeEmail()
{
  $userEmail = User::get();


  return response()->json(['success' => true, 'email' => $userEmail],200);
}
}
