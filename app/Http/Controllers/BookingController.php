<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking');
    }


    public function cariSlotFleksibel($waktuMulai, $jumlahMobil)
    {
        $mobilPerSlot = 3;
        $durasiCuciSLot = 30;

        $mulai = Carbon::parse($waktuMulai);
        $menit = floor($mulai->minute / 30) * 30;
        $slotWaktu = $mulai->copy()->setTime($mulai->hour, $menit)->second(0);

        $jadwal = [];

        for ($i = 0; $i < $jumlahMobil; $i++) {
            while (true) {
                $jumlahDiSlot = Booking::where('waktu_booking', $slotWaktu)->count();

                if ($jumlahDiSlot < $mobilPerSlot) {
                    $jadwal[] = $slotWaktu->copy();
                    break;
                }

                $slotWaktu->addMinutes($durasiCuciSLot); // geser ke slot berikutnya
            }
        }
        return $jadwal;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'jumlah_mobil' => 'required',
            'waktu_mulai' => 'required|date_format:Y-m-d\TH:i'
        ]);

        $slots = $this->cariSlotFleksibel($request->waktu_mulai, $request->jumlah_mobil);

        foreach ($slots as $slot) {
            Booking::create([
                'nama_pelanggan' => $request->nama_pelanggan,
                'waktu_booking' => $slot
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('booking');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
