<?php
/**
 * Stats Cards Widget
 * 
 * @var array $employeeCount
 * @var array $leaveCount
 * @var int $announcementCount
 * @var string $latestAttendance
 */
?>

<!-- New Employee -->
<div class="col-sm-6 col-lg-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <span class="bg-success text-white avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                            <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                            <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                        </svg>
                    </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium"><?= $employeeCount['total'] ?> Employee</div>
                    <div class="text-secondary"><?= $employeeCount['new'] ?> New Employee this month</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leave Count -->
<div class="col-sm-6 col-lg-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <span class="bg-primary text-white avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-cog">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 21h-6a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v5"></path>
                            <path d="M16 3v4"></path>
                            <path d="M8 3v4"></path>
                            <path d="M4 11h16"></path>
                            <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                            <path d="M19.001 15.5v1.5"></path>
                            <path d="M19.001 21v1.5"></path>
                            <path d="M22.032 17.25l-1.299 .75"></path>
                            <path d="M17.27 20l-1.3 .75"></path>
                            <path d="M15.97 17.25l1.3 .75"></path>
                            <path d="M20.733 20l1.3 .75"></path>
                        </svg>
                    </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium"><?= $leaveCount['total'] ?> Leaves created</div>
                    <div class="text-secondary"><?= $leaveCount['pending'] ?> still pending</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Announcement Count -->
<div class="col-sm-6 col-lg-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <span class="bg-red text-white avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-speakerphone">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M18 8a3 3 0 0 1 0 6"></path>
                            <path d="M10 8v11a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1v-5"></path>
                            <path d="M12 8h0l4.524 -3.77a.9 .9 0 0 1 1.476 .692v12.156a.9 .9 0 0 1 -1.476 .692l-4.524 -3.77h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h8"></path>
                        </svg>
                    </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium">Announcement</div>
                    <div class="text-secondary"><?= $announcementCount ?> new announcements</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Latest data -->
<div class="col-sm-6 col-lg-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <span class="bg-teal text-white avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-fingerprint">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M18.9 7a8 8 0 0 1 1.1 5v1a6 6 0 0 0 .8 3"></path>
                            <path d="M8 11a4 4 0 0 1 8 0v1a10 10 0 0 0 2 6"></path>
                            <path d="M12 11v2a14 14 0 0 0 2.5 8"></path>
                            <path d="M8 15a18 18 0 0 0 1.8 6"></path>
                            <path d="M4.9 19a22 22 0 0 1 -.9 -7v-1a8 8 0 0 1 12 -6.95"></path>
                        </svg>
                    </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium">Attendance</div>
                    <div class="text-secondary"><?= dateFormat($latestAttendance, 'm/d/Y') ?> latest data</div>
                </div>
            </div>
        </div>
    </div>
</div> 