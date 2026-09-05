<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        return view('profile.index', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'current_password' => ['nullable', 'string', 'required_with:new_password'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed']
        ]);

        // Şifre değişikliği kontrolü
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'message' => 'Mevcut şifreniz doğru değil.'
                ], 422);
            }

            $user->password = Hash::make($request->new_password);
        }

        // Profil fotoğrafı işleme
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->save();

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Profil bilgileriniz başarıyla güncellendi.'
            ]);
        }

        return back()->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('profile.orders', compact('orders'));
    }

    public function favorites()
    {
        $favorites = auth()->user()->favorites()
            ->with(['category', 'brand'])
            ->whereNotNull('parts.id')
            ->paginate(12);
        
        return view('profile.favorites', compact('favorites'));
    }

    public function toggleFavorite(Request $request, $partId)
    {
        $user = auth()->user();
        
        if ($user->favorites()->where('part_id', $partId)->exists()) {
            $user->favorites()->detach($partId);
            $message = 'Parça favorilerden kaldırıldı.';
        } else {
            $user->favorites()->attach($partId);
            $message = 'Parça favorilere eklendi.';
        }

        if ($request->ajax()) {
            return response()->json(['message' => $message]);
        }

        return back()->with('success', $message);
    }

    public function addresses()
    {
        $addresses = auth()->user()->addresses;
        return view('profile.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:10'],
        ]);

        auth()->user()->addresses()->create($validated);

        return back()->with('success', 'Adres başarıyla eklendi.');
    }

    public function updateAddress(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:10'],
        ]);

        $address->update($validated);

        return back()->with('success', 'Adres başarıyla güncellendi.');
    }

    public function destroyAddress(Address $address)
    {
        $this->authorize('delete', $address);

        $address->delete();

        return back()->with('success', 'Adres başarıyla silindi.');
    }

    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Kullanıcı şifresini güncelle
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();

        // Mevcut şifre kontrolü
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mevcut şifreniz doğru değil.']);
        }

        // Şifreyi güncelle
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Şifreniz başarıyla güncellendi.');
    }

    /**
     * Show specific order details
     */
    public function showOrder($orderId)
    {
        $order = auth()->user()->orders()->with(['items.part.category', 'items.part.brand', 'address'])->findOrFail($orderId);
        
        return view('orders.show', compact('order'));
    }
}