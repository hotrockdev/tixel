<div>
    <div class="mx-auto p-4" x-data="{ expanded: [] }">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <span class="hidden md:inline">Date</span>
                        <span class="inline md:hidden">Time</span>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Email</th>
                    <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Phone</th>
                    <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Amount Due</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">&nbsp;</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $o)
                    <tr>
                        <td class="text-xs px-4 py-2">{{ str_pad($o->id, 8, '0', STR_PAD_LEFT) }}</td>
                        <td class="text-xs px-4 py-2">
                            <span class="hidden md:inline">
                                {{ $o->created_at->format('F j, Y, g:i a') }}
                            </span>
                            <span class="inline md:hidden">
                                {{ $o->created_at->format('g:i a') }}
                            </span>
                        </td>
                        <td class="text-xs px-4 py-2">{{ $o->customer_name }}</td>
                        <td class="hidden md:table-cell text-xs px-4 py-2">{{ $o->customer_email }}</td>
                        <td class="hidden md:table-cell text-xs px-4 py-2">{{ $o->customer_phone }}</td>
                        <td class="hidden md:table-cell text-xs px-4 py-2 text-right">${{ number_format($o->total) }}</td>
                        <td class="text-xs px-4 py-2">
                            <button @click="expanded.includes({{ $o->id }}) ? expanded.splice(expanded.indexOf({{ $o->id }}), 1) : expanded.push({{ $o->id }})"
                                    class="text-indigo-600 hover:text-indigo-900">
                                Items
                            </button>
                        </td>
                    </tr>
                    <tr x-show="expanded.includes({{ $o->id }})">
                        <td colspan="9">
                            <div class="max-w-7xl">
                                <table class="w-full divide-y divide-gray-200">
                                    @forelse($o->order_items as $i)
                                        <tr>
                                            <td class="text-xs px-4 py-2">{{ ucfirst(strtolower($i->type)) }}</td>
                                            <td class="hidden md:table-cell text-xs px-4 py-2">{{ $i->instructions }}</td>
                                            <td class="text-xs px-4 py-2">Item Cost: ${{ number_format($i->amount) }}</td>
                                            <td class="text-xs px-4 py-2">
                                                <div class="flex justify-end">
                                                    <select
                                                        wire:key="{{ $i->id }}"
                                                        wire:change="setItemStatus($event.target.value, {{ $i->id }})"
                                                        name="select-menu"
                                                        class="text-xs mt-1 block w-52 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                    >
                                                        @foreach($statuses as $s)
                                                            <option value="{{ $s->value }}" @if($s->value === $i->status) selected @endif>{{ ucfirst(strtolower($s->value)) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No items found on this order.</td>
                                        </tr>
                                    @endforelse
                                </table>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4">
                            No orders found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
