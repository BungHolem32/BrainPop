<?php

return [
    "success" => [
        "index"                 => ["message" => "records return successful", "status" => 200],
        "show"                  => ["message" => "record with the id %d returned successfully", "status" => 200],
        "update"                => ["message" => "we successfully  update the record with the id %d", "status" => 201],
        "store"                 => ["message" => "record with the id %d saved successfully", "status" => 201],
        "destroy"               => [
            "message" => "you successfully deleted the record with the id of %d",
            "status"  => 200
        ],
        "getUsersByPeriodId"    => [
            "message" => "here are all the students that related to the period with id of %d",
            "status"  => 200
        ],
        "attachStudent"         => [
            "message" => "you successfully attached the student with the id of %d",
            "status"  => 200
        ],
        "detachStudent"         => [
            "message" => "you successfully detached the student with the id of %d",
            "status"  => 200
        ],
        "getPeriodsByTeacherId" => [
            "message" => "these are the periods that associated with teacher id  %d",
            "status"  => 200
        ],
        "login"                 => ["message" => "you logged successfully", "status" => 200],
        'register'              => [
            "message" => 'congratulation you successfully register as a new user',
            'status'  => 200
        ],
        "logout"                => [
            "message" => "you logged out successfully",
            "status"  => 200
        ],
        "getAuthUser"           => [
            "message" => "you successfully get your authenticated user",
            "status"  => 200
        ]

    ],
    "error"   => [
        "index"                 => ["message" => "no records found", "status" => 400],
        "show"                  => ["message" => "no record found", "status" => 404],
        "update"                => ["message" => "we failed to update the record with the id %d", "status" => 404],
        "store"                 => [
            "message" => "record was not saved, for more info , contact the admin",
            "status"  => 404
        ],
        "destroy"               => [
            "message" => "you failed to delete the record with the id of %d",
            "status"  => 404
        ],
        "getUsersByPeriodId"    => [
            "message" => "No students related to  period id  %d",
            "status"  => 404
        ],
        "attachStudent"         => [
            "message" => "You failed to attach the student with the id of %d\"",
            "status"  => 200
        ],
        "detachStudent"         => [
            "message" => "You failed to detach the student with the id of  %d",
            "status"  => 200
        ],
        "getPeriodsByTeacherId" => [
            "message" => "No periods found that associated with teacher id of %d",
            "status"  => 200
        ],
        "login"                 => [
            "message" => "Invalid username or password",
            "status"  => 401
        ],
        'register'              => [
            "message" => 'Sorry, it seems like you failed in your registration, for more information, please contact your admin',
            "status"  => 401
        ],
        "logout"                => [
            "message" => "Sorry, the user cannot be logged out",
            "status"  => 500
        ],
        "getAuthUser"           => [
            "message" => "Sorry, you failed  getting info about the user",
            "status"  => 401
        ]

    ]
];
