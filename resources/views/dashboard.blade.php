<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-auto w-full border">
                        <thead class="border-b-2">
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($customers) > 0)
                        @foreach($customers as $customer)
                        <tr class="text-center border-b-2 p-2">
                            <td>{{$customer['first_name']}} {{$customer['last_name']}}</td>
                            <td>{{$customer['email']}}</td>
                            <td>{{$customer['phone']}}</td>
                            <td>
                                @foreach($categories as $category)
                                    @if($customer['category'] == $category['id'])
                                    {{$category['category_name']}}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('editcustomer', ['customer' => $customer['id']])}}" class="hover:text-green-300 text-green-800 text-sm font-bold m-1">
                                    <span class="material-icons-outlined">edit</span>
                                </a>
                                <a href="{{route('delcustomer', ['customer' => $customer['id']])}}" onclick="return confirm('Are you sure you want to delete this form?')" class="hover:text-red-300 text-red-700 text-sm font-bold mx-2 p-2">
                                    <span class="material-icons-outlined">delete_forever</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="text-center border-b-2 p-2">
                            <td colspan="5" class="text-xl p-14">No Customers Found</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
