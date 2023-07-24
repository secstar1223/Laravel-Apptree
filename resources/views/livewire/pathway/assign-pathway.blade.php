<div>
    <h4 class="text-lg font-bold text-darkgreen">Assign Pathway</h4>


    <div class="mt-8">
        <div>
            <nav class="flex space-x-4" aria-label="Tabs">

                <a href="#" class="px-3 py-2 text-sm font-medium rounded-md bg-darkgreen/10 text-darkgreen"
                    aria-current="page">Individuals</a>

                <a href="#"
                    class="px-3 py-2 text-sm font-medium text-gray-500 rounded-md cursor-not-allowed hover:text-gray-700">Cohorts</a>
            </nav>
        </div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flow-root mt-8">
            <div class="-mx-4 -my-2 overflow-x-auto border rounded-md sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th width="25%" scope="col"
                                    class="px-6 py-3.5 text-left text-sm font-normal text-gray-600">
                                    Assign</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-normal text-gray-600">
                                    Name</th>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                        <input type="checkbox" wire:model="assign_users" value="{{ $user->id }}">
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="{{ $user->profile_photo_url }}" class="w-6 h-6 mr-2 rounded-md">
                                            <span class="text-gray-900">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-3 mt-8">
        <button x-data type="button" class="btn-light" x-on:click="closeModal()">Cancel</button>
        <button type="button" wire:click="assign" class="btn-primary btn-sm">
            Save
        </button>
    </div>


</div>
