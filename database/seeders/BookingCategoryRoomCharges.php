<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomCategoryCharge;
use Illuminate\Database\Seeder;

class BookingCategoryRoomCharges extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /////////////////////////////////////////////////////////////////////////////

        // $rooms = array(
        //     array('id' => '1','room_title' => 'Room C-1','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'C-Block','is_reserved' => '1','floor' => 'First','single_person_charges' => '0','double_person_charges' => '0','member_self' => '8000','member_guest' => '12000'),
        //     array('id' => '2','room_title' => 'Room C-2','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'C-Block','is_reserved' => '1','floor' => 'First','single_person_charges' => '0','double_person_charges' => '0','member_self' => '8000','member_guest' => '12000'),
        //     array('id' => '3','room_title' => 'Room C-3','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'C-Block','is_reserved' => '1','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '4','room_title' => 'Room C-4','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'C-Block','is_reserved' => '1','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '5','room_title' => 'Room C-5','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'C-Block','is_reserved' => '1','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '6','room_title' => 'Room C-6','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'C-Block','is_reserved' => '1','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '7','room_title' => 'Room A-208','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'B-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '8000','member_guest' => '12000'),
        //     array('id' => '8','room_title' => 'Room A-209','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'B-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '8000','member_guest' => '12000'),
        //     array('id' => '9','room_title' => 'Room A-210','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'B-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '8000','member_guest' => '12000'),
        //     array('id' => '10','room_title' => 'Room A-211','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'B-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '8000','member_guest' => '12000'),
        //     array('id' => '11','room_title' => 'Room A-212','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'B-Block','is_reserved' => '0','floor' => 'First','single_person_charges' => '0','double_person_charges' => '0','member_self' => '8000','member_guest' => '12000'),
        //     array('id' => '12','room_title' => 'Room A-213','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'B-Block','is_reserved' => '0','floor' => 'First','single_person_charges' => '0','double_person_charges' => '0','member_self' => '8000','member_guest' => '12000'),
        //     array('id' => '13','room_title' => 'Room A-214','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'B-Block','is_reserved' => '0','floor' => 'First','single_person_charges' => '0','double_person_charges' => '0','member_self' => '8000','member_guest' => '12000'),
        //     array('id' => '14','room_title' => 'Room A-215','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'B-Block','is_reserved' => '0','floor' => 'First','single_person_charges' => '0','double_person_charges' => '0','member_self' => '8000','member_guest' => '12000'),
        //     array('id' => '15','room_title' => 'Room A-102','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'A-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '16','room_title' => 'Room A-103','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'A-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '17','room_title' => 'Room A-104','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'A-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '18','room_title' => 'Room A-105','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'A-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '19','room_title' => 'Room A-106','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'A-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '20','room_title' => 'Room A-107','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'A-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '21','room_title' => 'Room A-108','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'A-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '22','room_title' => 'Room A-109','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'A-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '23','room_title' => 'Room A-110','created_at' => NULL,'updated_at' => NULL,'category_id' => '1','block' => 'A-Block','is_reserved' => '0','floor' => 'Ground','single_person_charges' => '0','double_person_charges' => '0','member_self' => '5000','member_guest' => '9000'),
        //     array('id' => '24','room_title' => 'Room A-201','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'A-Block','is_reserved' => '0','floor' => 'First','single_person_charges' => '8000','double_person_charges' => '12000','member_self' => '0','member_guest' => '0'),
        //     array('id' => '25','room_title' => 'Room A-202','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'A-Block','is_reserved' => '0','floor' => 'First','single_person_charges' => '8000','double_person_charges' => '12000','member_self' => '0','member_guest' => '0'),
        //     array('id' => '26','room_title' => 'Room A-203','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'A-Block','is_reserved' => '0','floor' => 'First','single_person_charges' => '8000','double_person_charges' => '12000','member_self' => '0','member_guest' => '0'),
        //     array('id' => '27','room_title' => 'Room A-204','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'A-Block','is_reserved' => '0','floor' => 'First','single_person_charges' => '8000','double_person_charges' => '12000','member_self' => '0','member_guest' => '0'),
        //     array('id' => '28','room_title' => 'Room A-205','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'A-Block','is_reserved' => '0','floor' => 'First','single_person_charges' => '8000','double_person_charges' => '12000','member_self' => '0','member_guest' => '0'),
        //     array('id' => '29','room_title' => 'Room A-206','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'A-Block','is_reserved' => '0','floor' => 'First','single_person_charges' => '8000','double_person_charges' => '12000','member_self' => '0','member_guest' => '0'),
        //     array('id' => '30','room_title' => 'Room A-207','created_at' => NULL,'updated_at' => NULL,'category_id' => '2','block' => 'A-Block','is_reserved' => '0','floor' => 'First','single_person_charges' => '8000','double_person_charges' => '12000','member_self' => '0','member_guest' => '0')
        // );


        ///////////////////////////////////////////////////////////////////////////////
        // $charges = [
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 1,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 2,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 3,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 4,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 5,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 6,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 7,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 8,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 9,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 10,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 11,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 12,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 13,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 14,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 15,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 16,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 17,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 18,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 19,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 20,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 21,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 22,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 23,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 24,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 25,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 26,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 27,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 28,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 29,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
        //     [
        //         'room_category_id' => 2,
        //         'room_id' => 30,
        //         'single_person_charges' => 5500,
        //         'double_person_charges' => 6000,
        //         'member_self' => 0,
        //         'member_guest' => 0,
        //     ],
            
        // ]; 
        $charges = [];
        $roomsData = Room::all();
        // dd($roomsData);

        foreach($roomsData as $key=>$room){
            $charges[] = [
                        'room_category_id' => $room->category_id,
                        'room_id' => $room->id,
                        'single_person_charges' => 0,
                        'double_person_charges' => 0,
                        'member_self' => $room->member_self,
                        'member_guest' => $room->member_guest,
                        'tenant_id' => 'pcom',
            ];
             
            
        }
        

        RoomCategoryCharge::insert($charges);
    }
}
