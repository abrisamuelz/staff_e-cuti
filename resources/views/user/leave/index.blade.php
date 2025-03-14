@extends('layouts.app')

@section('header')
    <h2 class="font-weight-bold text-xl text-dark">
        {{ __('Monthly Calendar') }}
    </h2>
@endsection

@section('content')
    <style>
        /* General layout using CSS Grid */
        .calendar-wrapper {
            display: grid;
            grid-template-columns: 1fr 3fr;
            /* Summary on the left, calendar on the right for desktop */
            gap: 1.0rem;
            align-items: start;
        }

        /* Summary Card */
        .summary-card {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 1rem;
        }

        .summary-card h5 {
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        /* Calendar */
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            /* 7 columns for desktop */
            gap: 0.3rem;
        }

        .day-cell {
            border: 1px solid #ced4da;
            border-radius: 10px;
            padding: 10px;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .today {
            background-color: #bfefff;
        }

        .work-hours {
            font-weight: bold;
        }

        .work-hours.more {
            color: green;
        }

        .work-hours.less {
            color: red;
        }

        .bg-grey {
            background-color: #e0e0e0;
        }

        .holiday-name {
            font-size: 0.85rem;
            color: #333;
            margin-top: 5px;
            font-style: italic;
        }

        /* Mobile-specific styles */
        @media (max-width: 768px) {
            .calendar-wrapper {
                grid-template-columns: 1fr;
                /* Single column for mobile */
                gap: 1rem;
            }

            .summary-card {
                width: 100%;
                margin-bottom: 0;
            }

            .calendar {
                grid-template-columns: 1fr;
                /* Single column for mobile view */
                gap: 1rem;
            }

            .day-cell {
                padding: 15px;
                min-height: 60px;
            }

            /* Hide weekday headers on mobile */
            .calendar>div.text-center {
                display: none;
            }

            /* Remove the invisible cells in mobile view */
            .day-cell.invisible {
                display: none;
            }
        }
    </style>

    <div class="container py-5">
        <div class="d-flex justify-content-between mb-3">
            {{-- Previous Month Button (up to 4 months ago) --}}
            <a href="{{ route('user.leave.index', ['month' => $previousMonth->format('Y-m')]) }}" class="btn btn-secondary"
                @if ($selectedMonth->diffInMonths(\Carbon\Carbon::now()) >= 4) disabled @endif>
                Previous Month
            </a>

            <h3>{{ $selectedMonth->format('F Y') }}</h3>

            {{-- Next Month Button (disabled if the current month is the latest) --}}
            <a href="{{ route('user.leave.index', ['month' => $nextMonth->format('Y-m')]) }}" class="btn btn-secondary"
                @if ($selectedMonth->greaterThanOrEqualTo(\Carbon\Carbon::now())) disabled @endif>
                Next Month
            </a>
        </div>

        <div class="calendar-wrapper">
            <div class="summary-card">
                <h5>Annual Leave {{ $selectedMonth->format('Y') }}</h5>
                <div class="summary-item">
                    <span>Total:</span>
                    <span>{{ $summary['totalWorkHours'] ?? 'N/A' }} hours</span>
                </div>
                <div class="summary-item">
                    <span>Booked / Taken:</span>
                    <span>{{ $summary['totalWorkDays'] ?? 'N/A' }} days
                        ({{ $summary['totalWorkDaysWithCheckInAndCheckOut'] ?? 'N/A' }} with in/out)</span>
                </div>
                <div class="summary-item">
                    <span>Total Others:</span>
                    <span>{{ $summary['totalWorkDaysRemaining'] ?? 'N/A' }} days</span>
                </div>
                <div class="summary-item">
                    <span>Remaining:</span>
                    <span>{{ $summary['totalInOffices'] ?? 'N/A' }} days</span>
                </div>
            </div>

            <!-- Calendar on the right side -->
            <div class="calendar">
                {{-- Weekday headers (hidden on mobile view) --}}
                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="text-center font-weight-bold">{{ $day }}</div>
                @endforeach

                {{-- Fill in blank cells for days before the month starts (hidden on mobile) --}}
                @for ($i = 0; $i < $selectedMonth->copy()->startOfMonth()->dayOfWeek; $i++)
                    <div class="day-cell invisible"></div>
                @endfor

                {{-- Display day cells --}}
                @for ($day = 1; $day <= $selectedMonth->daysInMonth; $day++)
                    @php
                        $date = $selectedMonth->copy()->day($day);
                        $isHoliday = array_key_exists($date->format('Y-m-d'), $holidays);
                        $isWeekend = in_array($date->dayOfWeek, $weekendDays);
                        $holidayName = $isHoliday ? $holidays[$date->format('Y-m-d')] : null;
                    @endphp
                    <div
                        class="day-cell {{ $date->isToday() ? 'today' : '' }} {{ $isHoliday || $isWeekend ? 'bg-grey' : '' }}">
                        <div>
                            <strong>{{ $day }}</strong>
                            <span class="d-block d-sm-none">{{ $date->format('D') }}</span>
                        </div>
                        @if ($isHoliday)
                            <div class="holiday-name">
                                {{ \Illuminate\Support\Str::limit($holidayName, $holidayNameLimit) }}
                            </div>
                        @endif
                        @php
                            $attendance = null;
                        @endphp
                        @if ($attendance)
                            <div class="text-success @if (Carbon\Carbon::parse($attendance->workSchedule->check_in)->addMinutes($attendance->workSchedule->late_tolerance) <
                                    Carbon\Carbon::parse($attendance->check_in)) text-danger @endif">
                                <i class="fas fa-sign-in-alt"></i> : {{ $attendance->check_in ?? 'N/A' }}
                            </div>
                            <div class="text-success @if (Carbon\Carbon::parse($attendance->workSchedule->check_out) > Carbon\Carbon::parse($attendance->check_out)) text-danger @endif">
                                <i class="fas fa-sign-out-alt"></i> : {{ $attendance->check_out ?? 'N/A' }}
                            </div>
                            <div class="text-success @if ($attendance->workSchedule->work_hours > Carbon\Carbon::parse($attendance->todayWorkHours())->format('H')) text-danger @endif">
                                <i class="fas fa-clock"></i> : {{ $attendance->todayWorkHours() ?? 'N/A' }}
                                @if ($attendance->todayWorkHours())
                                    Hours
                                @endif
                            </div>
                            <div>
                                <i class="fas fa-map-marked-alt"></i> :
                                {{ $attendance->location == 0 ? 'Office' : 'Out Of Office' }}
                            </div>
                        @else
                            <div class="text-muted">
                                No Data
                            </div>
                        @endif
                    </div>
                @endfor

                {{-- Fill in blank cells for days after the month ends (hidden on mobile) --}}
                @for ($i = $selectedMonth->copy()->endOfMonth()->dayOfWeek + 1; $i <= 6; $i++)
                    <div class="day-cell invisible"></div>
                @endfor
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Scroll to the current date on mobile view
            const todayElement = document.querySelector(".day-cell.today");
            if (todayElement && window.innerWidth <= 768) {
                todayElement.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }
        });
    </script>
@endsection
