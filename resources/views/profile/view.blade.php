<x-app-layout>
    <div x-data="{
            flashMessage: '{{ \Illuminate\Support\Facades\Session::get('flash_message') }}',
            states: {{ json_encode($states) }}, // States are directly loaded
            billingAddress: {{ json_encode([
                'address1' => old('billing.address1', $billingAddress->address1),
                'address2' => old('billing.address2', $billingAddress->address2),
                'city' => old('billing.city', $billingAddress->city),
                'state_id' => old('billing.state_id', $billingAddress->state_id),
                'zipcode' => old('billing.zipcode', $billingAddress->zipcode),
            ]) }},
            shippingAddress: {{ json_encode([
                'address1' => old('shipping.address1', $shippingAddress->address1),
                'address2' => old('shipping.address2', $shippingAddress->address2),
                'city' => old('shipping.city', $shippingAddress->city),
                'state_id' => old('shipping.state_id', $shippingAddress->state_id),
                'zipcode' => old('shipping.zipcode', $shippingAddress->zipcode),
            ]) }},
            init() {
                if (this.flashMessage) {
                    setTimeout(() => this.$dispatch('notify', { message: this.flashMessage }), 200);
                }
            }
        }" class="container mx-auto lg:w-2/3 p-5">
        
        <!-- Display errors if any -->
        @if (session('error'))
            <div class="py-2 px-3 bg-red-500 text-white mb-2 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Profile Form -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div class="bg-white p-3 shadow rounded-lg md:col-span-2">
                <form action="{{ route('profile.update') }}" method="post">
                    @csrf
                    <h2 class="text-xl font-semibold mb-2">Profile Details</h2>

                    <!-- Name Fields -->
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <x-input type="text" name="first_name" value="{{ old('first_name', $customer->first_name) }}"
                            placeholder="First Name" class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        <x-input type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}"
                            placeholder="Last Name" class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <x-input type="text" name="email" value="{{ old('email', $user->email) }}"
                            placeholder="Your Email" class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>

                    <!-- Phone Field -->
                    <div class="mb-3">
                        <x-input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                            placeholder="Your Phone" class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>

                    <!-- Billing Address -->
                    <h2 class="text-xl mt-6 font-semibold mb-2">Billing Address</h2>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <x-input type="text" name="billing[address1]" x-model="billingAddress.address1"
                            placeholder="Address 1" class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        <x-input type="text" name="billing[address2]" x-model="billingAddress.address2"
                            placeholder="Address 2" class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>

                    <!-- City and ZipCode -->
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <x-input type="text" name="billing[city]" x-model="billingAddress.city" placeholder="City"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        <x-input type="text" name="billing[zipcode]" x-model="billingAddress.zipcode" placeholder="ZipCode"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>

                    <!-- State Selection for Billing -->
                    <div class="mb-3">
                        <x-input type="select" name="billing[state_id]" x-model="billingAddress.state_id"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded">
                            <option value="">Select State</option>
                            <template x-for="state in states" :key="state.id">
                                <option :value="state.id" :selected="state.id == billingAddress.state_id" x-text="state.name"></option>
                            </template>
                        </x-input>
                    </div>

                    <!-- Shipping Address -->
                    <div class="flex justify-between mt-6 mb-2">
                        <h2 class="text-xl font-semibold">Shipping Address</h2>
                        <label for="sameAsBillingAddress" class="text-gray-700">
                            <input @change="$event.target.checked ? shippingAddress = {...billingAddress} : ''"
                                id="sameAsBillingAddress" type="checkbox"
                                class="text-purple-600 focus:ring-purple-600 mr-2"> Same as Billing
                        </label>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <x-input type="text" name="shipping[address1]" x-model="shippingAddress.address1"
                            placeholder="Address 1" class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        <x-input type="text" name="shipping[address2]" x-model="shippingAddress.address2"
                            placeholder="Address 2" class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>

                    <!-- City and ZipCode for Shipping -->
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <x-input type="text" name="shipping[city]" x-model="shippingAddress.city" placeholder="City"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        <x-input name="shipping[zipcode]" x-model="shippingAddress.zipcode" type="text" placeholder="ZipCode"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>

                    <!-- State Selection for Shipping -->
                    <div class="mb-3">
                        <x-input type="select" name="shipping[state_id]" x-model="shippingAddress.state_id"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded">
                            <option value="">Select State</option>
                            <template x-for="state in states" :key="state.id">
                                <option :value="state.id" :selected="state.id == shippingAddress.state_id" x-text="state.name"></option>
                            </template>
                        </x-input>
                    </div>                    

                    <!-- Update Button -->
                    <x-button type="submit" class="w-full">Update Profile</x-button>
                </form>
            </div>

            <!-- Update Password -->
            <div class="bg-white p-3 shadow rounded-lg">
                <form action="{{ route('profile_password.update') }}" method="post">
                    @csrf
                    <h2 class="text-xl font-semibold mb-2">Update Password</h2>
                    <x-input type="password" name="old_password" placeholder="Your Current Password"
                        class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    <x-input type="password" name="new_password" placeholder="New Password"
                        class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    <x-input type="password" name="new_password_confirmation" placeholder="Repeat New Password"
                        class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    <x-button>Update</x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>