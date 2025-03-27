<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Employee;
use App\Models\UserLevels;
use App\Models\Employments;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['login', 'register']]);
  }
  /**
   * Get a JWT via given credentials.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
      'password' => 'required|string|min:6',
    ]);
    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }
    if (!$token = auth()->attempt($validator->validated())) {
      return response()->json(['error' => 'Unauthorized']);
    }
    return $this->createNewToken($token);

    // $credentials = $request->only('email', 'password');

    // if (!$token = JWTAuth::attempt($credentials)) {
    //     return response()->json(['error' => 'invalid_credentials'], 401);
    // }

    // return response()->json(['token' => $token]);
  }
  /**
   * Register a User.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'username' => 'required|string|between:2,100',
      'email' => 'required|string|email|max:100|unique:users',
      'password' => 'required|string|confirmed|min:6',
      // 'account_id' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json($validator->errors()->toJson(), 400);
    }
    $user = User::create(array_merge(
      $validator->validated(),
      ['password' => bcrypt($request->password)]
    ));
    return response()->json([
      'message' => 'User successfully registered',
      'user' => $user
    ], 201);
  }

  /**
   * Log the user out (Invalidate the token).
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    auth()->logout();
    return response()->json(['message' => 'User successfully signed out']);
  }
  /**
   * Refresh a token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh()
  {
    return $this->createNewToken(auth()->refresh());
  }
  /**
   * Get the authenticated User.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function userProfile()
  {
    $user = Auth::user();
    $role = UserLevels::find($user->level_id);
    $employees = Employee::where('user_id', $user->id)->with([
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
              ->with([
                'leave_credits' => function ($q) {
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
        'government' => function ($q) {
          $q->select('*')->with([
            'tax_status' => function ($q) {
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
      ])->with([
        'requirements' => function ($q) {
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
      
    $dataUser = [
      'id'        => auth()->user()->id,
      'email'     => auth()->user()->email,
      'username' => auth()->user()->username,
      'user'    => $user,
      'level_id'      => $role->name,
      'employees'      => $employees
    ];
    return response()->json(['success' => true, 'dataUser' => $dataUser], 200);
  }
  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function createNewToken($token)
  {
    // return response()->json([
    //     'access_token' => $token,
    //     'token_type' => 'bearer',
    //     'expires_in' => auth()->factory()->getTTL() * 60,
    //     'user' => auth()->user()
    // ]);

    // id || Role Name
    //=========================
    // 1  || SuperAdmin
    // 2  || HR Administor
    // 3  || Manager / Supervisor
    // 4  || Employee

    if (Auth::user()->level_id == 1) {
      $ability = [
        ['action' => 'manage', 'subject' => 'SystemAdmin'],
        ['action' => 'manage', 'subject' => 'SystemAndHrAdmin'],
      ];
    }
    if (Auth::user()->level_id == 2) {
      $ability = [
        ['action' => 'manage', 'subject' => 'HrAdmin'],
        ['action' => 'manage', 'subject' => 'SystemAndHrAdmin'],
      ];
    }
    if (Auth::user()->level_id == 3) {
      $ability = [
        ['action' => 'manage', 'subject' => 'ManagerSupervisor'],
        ['action' => 'manage', 'subject' => 'AdminAndManager'],
      ];
    }
    if (Auth::user()->level_id == 4) {
      $ability = [
        ['action' => 'manage', 'subject' => 'Employee'],
        ['action' => 'manage', 'subject' => 'AdminAndEmployee'],
      ];
    }

    $user = Auth::user();
    $role = UserLevels::find($user->level_id);

    if ($role->id == 1) {
      $users = 'SIRIUS HR SYSTEM';
    }
    if ($role->id == 2) {
      $userAdmin = Employee::where('user_id', $user->id)->first();
      $userData = User::find($userAdmin->user_id);
      $users = $userData->users;
    }
    if ($role->id >= 3) {
      $staff = Employments::where('user_id', $user->id)->first();
      $branchData = User::find($staff->user_id);
      $users = $branchData->users;
    }

    $dataUser = [
      'id'        => auth()->user()->id,
      'email'     => auth()->user()->email,
      'username' => auth()->user()->username,
      'user'    => $user,
      'level_id'      => $role->name,
      'ability'   => $ability
    ];

    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      // 'expires_in' => auth()->factory()->getTTL() * 60,
      'user'          => $dataUser,
    ]);
  } // protected function createNewToken($token)


  public function getUserID()
  {
    $user = Auth::user();
    $user_id = $user->id;

    return response()->json([
      'success' => true,
      'user_id' => $user_id,
    ]);
  }

  public function guard()
  {
    return Auth::guard();
  } // public function guard()

  public function Editpass()
  {
    $user = Auth::user();
    $changepass = User::find($user->id)->first();
    if (request('newpass')) {
      $changepass->password = bcrypt(request('newpass'));
      $changepass->save();
    }
    return response()->json(['success' => true, 'changepass' => $changepass]);
  }

  public function getPasswordData()
  {
    $user = Auth::user();
    $password = $user->password;

    return response()->json([
        'success' => true,
        'password' => $password,
    ]);
  }
}
