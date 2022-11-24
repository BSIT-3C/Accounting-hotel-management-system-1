<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Account;
use App\Models\Employee;
use App\Models\Position;
use App\Models\RoomRate;
use App\Models\RoomType;
use App\Models\Blacklist;
use App\Models\Department;
use App\Models\RoomStatus;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\Housekeeping;
use App\Models\PaymentMethod;
use App\Models\Payroll;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Department::factory()->count(3)->sequence(['department' => 'Front Office'], ['department' => 'Accounting'], ['department' => 'House Keeping'],)
            ->create();

        Position::factory()->count(3)->sequence(['position' => 'Receptionist', 'department_id' => 1], ['position' => 'Accountant', 'department_id' => 2], ['position' => 'House Keeper', 'department_id' => 3])
            ->create();

        Payroll::factory()->count(1)->sequence(['position_id' => 1, 'gross_amount' => 20000, 'total_deduction' => 2000])
            ->create();

        RoomStatus::factory()->count(3)->sequence(['room_status' => 'Vacant'], ['room_status' => 'Occupied'], ['room_status' => 'Out-of-Order'])
            ->create();

        RoomType::factory()->count(4)->sequence(
            ['room_type' => 'Superior'],
            ['room_type' => 'Luxury'],
            ['room_type' => 'Club Room'],
            ['room_type' => 'Suite']
        )
            ->create();

        // edit this accordingly
        Role::factory()->count(6)->sequence(
            ['role' => 'Receptionist'],
            ['role' => 'Accountant'],
            ['role' => 'House Keeper'],
            ['role' => 'Admin'],
            ['role' => 'Front Desk'],
            ['role' => 'Manager']
        )
            ->create();

        PaymentMethod::factory()->count(3)->sequence(
            ['payment_method' => 'Cash'],
            ['payment_method' => 'Credit Card'],
            ['payment_method' => 'Debit Card'],
            ['payment_method' => 'Paypal'],
            ['payment_method' => 'GCash'],
            ['payment_method' => 'Other']
        )
            ->create();

        $this->createTenEntryPerFactory();

        RoomRate::factory()->count(4)->sequence(
            ['room_id' => 1, 'rate' => 1000],
            ['room_id' => 2, 'rate' => 2000],
            ['room_id' => 3, 'rate' => 3000],
            ['room_id' => 4, 'rate' => 4000]
        )
            ->create();

        Blacklist::factory()->count(3)->create();
    }

    public function createTenEntryPerFactory()
    {
        $factoryArray = [
            'room' => Room::factory(),
            'employee' => Employee::factory(),
            'guest' => Guest::factory(),
            'reservation' => Reservation::factory(),
            'housekeeping' => Housekeeping::factory(),
            'account' => Account::factory(),
            'transaction' => Transaction::factory(),
        ];

        foreach ($factoryArray as $key => $value) {
            for ($i = 1; $i <= 10; $i++) {
                if ($value == $factoryArray['account']) {
                    $value->create([
                        'employee_id' => $i,
                    ]);
                } else if ($value == $factoryArray['reservation']) {
                    $value->create([
                        'guest_id' => $i,
                    ]);
                } else if ($value == $factoryArray['transaction']) {
                    $value->create([
                        'reservation_id' => $i,
                        'guest_id' => $i,
                    ]);
                } else {
                    $value->create();
                }
            }
        }
    }
}
