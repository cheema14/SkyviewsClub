@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@section('styles')
<style>
.ts-wrapper {
    border: none !important;
    min-height: 50px;
}
.ts-dropdown {
    width: 95% !important;
}
</style>
@endsection

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.edit') }} {{ trans(tenant()->id.'/cruds.order.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.update", [$order->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @if($order->status != App\Models\Order::STATUS_SELECT["Complete"])
            <div class="form-group col-md-4">
                <label class="required" for="member_id">{{ trans(tenant()->id.'/cruds.order.fields.member') }}</label>
                <select class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="member_id" id="member_id" required>
                    @foreach($members as $id => $member)
                        <option value="{{ $member->id }}" {{ (old('member_id') ? old('member_id') : $order->member->id ?? '') == $member->id ? 'selected' : '' }}>{{ $member->membership_no }} - {{ $member->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('member') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.order.fields.member_helper') }}</span>
            </div>

            

            <div class="form-group col-md-4">
                <label class="required" for="menu">Table Top</label>
                <select class="form-control {{ $errors->has('table_top_id') ? 'is-invalid' : '' }}" name="table_top_id" id="table_top_id" required>
                    @foreach($tableTops as $id => $entry)
                        <option value="{{ $id }}" {{ (old('table_top_id') ? old('table_top_id') : $order->table_top_id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('table_top_id') }}
                    </div>
                @endif
                <span class="help-block"> </span>
            </div>

            <div class="form-group col-md-4">
                <label class="required">{{ trans(tenant()->id.'/cruds.order.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\Order::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $order->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.order.fields.status_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label class="required" for="no_of_guests">No of guests</label>
                <input class="form-control {{ $errors->has('no_of_guests') ? 'is-invalid' : '' }}" type="number" name="no_of_guests" id="no_of_guests" value="{{ old('no_of_guests', $order->no_of_guests) }}">
                @if($errors->has('no_of_guests'))
                    <div class="invalid-feedback">
                        {{ $errors->first('no_of_guests') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>

           
            
                <div class="card-body row" x-data="handler()" x-init="initTomSelect">

                    <div class="col-md-12">
                        <label for="photo">Select Items</label>
                        <table class="table table-bordered align-items-center table-sm">
                            <thead >
                                <tr>
                                    <th>#</th>
                                    <th>Menu</th>
                                    <th>Item</th>
                                    <th style="width:10%;">Price</th>
                                    <th style="width:10%;">Quantity</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(field, index) in fields" :key="index">
                                    <tr>
                                        <td x-text="index + 1"></td>
                                        <td>
                                                <select required x-model="field.pivot.menu_id"  
                                                    class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" 
                                                    :name="`items[${index}][menu_id]`" :id="`menu_id_${index}`" 
                                                    x-on:change="getItems(index)"
                                                >
                                                    @foreach($menus as $id => $entry)
                                                        <option value="{{ $id }}" x-bind:selected="field.pivot.menu_id == '{{ $id }}' ? true : false">{{ $entry }}</option>
                                                    @endforeach
                                                </select>
                                        </td> 
                                        <td>
                                                <select required x-model="field.item_id"  x-on:change="getPrice(index)" 
                                                    class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" 
                                                    :name="`items[${index}][item_id]`" :id="`item_id_${index}`" 
                                                >
                                                <option>Please select Item</option>
                                                @foreach($items as $id => $entry)                                                
                                                <option
                                                    value="{{ $id }}" x-bind:selected="field.id == '{{ $id }}' ? true : false">{{ $entry }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="hidden" x-model="field.pivot.price" :name="`items[${index}][price]`">
                                            <input required x-model="field.pivot.price" readonly class="form-control">
                                        </td>
                                        <td>
                                            <input
                                                x-model="field.pivot.quantity"
                                                class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" :name="`items[${index}][quantity]`" id="quantity" >
                                        </td>

                                        <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                                    </tr>
                                </template>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="12" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Add Items</button></td>
                                </tr>

                            </tfoot>
                        </table>
                    </div>

                </div>
            @endif
            
            @if($order->status == App\Models\Order::STATUS_SELECT["Complete"])
                <div class="form-group col-md-4">
                    <label class="" for="name">{{ trans(tenant()->id.'/cruds.cash_receipts.fields.pay_mode') }}</label>
                    <select class="form-control {{ $errors->has('pay_mode') ? 'is-invalid' : '' }}" name="pay_mode" id="pay_mode" required>
                        <option value="" disabled selected>Select Payment Method</option>
                        <option value="Cash" {{ ($order->payment_type == 'cash' ) ? "selected" : "" }}>Cash</option>
                        <option value="Card" {{ ($order->payment_type == 'card' ) ? "selected" : "" }}>Card</option>
                        <option value="Credit" {{ ($order->payment_type == 'credit' ) ? "selected" : "" }}>Credit</option>
                    </select>
                </div>
            @endif
            <div class="form-group col-md-4">
                <button class="btn btn-info px-5" type="submit">
                    {{ trans(tenant()->id.'/global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
<script>

    document.addEventListener("DOMContentLoaded", function() {
        
        new TomSelect("#member_id", {
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    
        
    
        
    });
    
</script>
<script>
    function handler() {

        return {
            fields: @json($order->items), 
            globalIndex:0,
            tomSelectInstances:[],
            initTomSelect() {
                this.$nextTick(() => {
                    // Initialize Tom Select for any new menu_id and item_id without destroying the previous ones
                    this.fields.forEach((field, index) => {
                        const menuId = `menu_id_${index}`;
                        const itemId = `item_id_${index}`;

                        // Check if the TomSelect instance is already initialized for this field
                        if (!this.tomSelectInstances || !this.tomSelectInstances[menuId]) {
                            // Initialize Tom Select for menu_id
                            const menuSelect = new TomSelect(`#${menuId}`, {
                                onChange: (value) => {
                                    this.fields[index].pivot.menu_id = value; // Update AlpineJS model
                                    this.getItems(index); // Call your custom function for menu changes
                                }
                            });

                            // Store instance by menuId to avoid reinitialization
                            if (!this.tomSelectInstances) this.tomSelectInstances = {};
                            this.tomSelectInstances[menuId] = menuSelect;
                        }

                        // Check if the TomSelect instance is already initialized for this field
                        if (!this.tomSelectInstances || !this.tomSelectInstances[itemId]) {
                            // Initialize Tom Select for item_id
                            const itemSelect = new TomSelect(`#${itemId}`, {
                                onChange: (value) => {
                                    this.fields[index].item_id = value; // Update AlpineJS model
                                    this.getPrice(index); // Call the getPrice function
                                }
                            });

                            // Store instance by itemId to avoid reinitialization
                            this.tomSelectInstances[itemId] = itemSelect;
                        }
                    });
                });
            },
            addNewField() {
                this.fields.push({
                    item_id: '',
                    menu_category_id:'',
                    pivot:{
                        price : '',
                        quantity : '',
                        menu_id:'',
                    }
                });
                this.initTomSelect(); 
            }
            , removeField(index) {
                this.fields.splice(index, 1);
            },
            // initSelect2() {
            //     // Reinitialize select2 for all .select2 elements
            //     this.$nextTick(() => {
            //         document.querySelectorAll('.select2').forEach(select => {
            //             $(select).select2();
            //         });
            //     });
            // },

            async getPrice(index) {

                let data = await (await fetch("{{ route('admin.items.getById') }}?item_id=" + this.fields[index].item_id)).json();
                console.log("change");
                this.fields[index].pivot.price = data.item.price;
            },
            async getItems(index) {
                // console.log("this.fields",this.fields[index]);
                let data = await (await fetch("{{ route('admin.items.getItemByMenu') }}?menu_id=" + this.fields[index].pivot.menu_id)).json();
                this.fields[index].pivot.price = data.item.price;


                const itemId = `item_id_${index}`;

                // Check if the Tom Select instance exists and destroy it if it does
                if (this.tomSelectInstances[itemId]) {
                    this.tomSelectInstances[itemId].destroy(); // Destroy the existing instance
                }

                // Initialize a new Tom Select instance
                this.$nextTick(() => {
                    this.tomSelectInstances[itemId] = new TomSelect(`#${itemId}`, {
                        onChange: (value) => {
                            this.fields[index].item_id = value; // Update AlpineJS model
                            this.getPrice(index); // Call the getPrice function after selecting an item
                        }
                    });

                    const tomSelectInstance = this.tomSelectInstances[itemId];
                    tomSelectInstance.clear(); // Clear existing options if necessary
                    tomSelectInstance.clearOptions(); // Removes all the current options

                    data.item.forEach(item => {
                        tomSelectInstance.addOption({ value: item.id, text: item.title });
                    });

                    // Optionally set the value if you want to select a default one
                    tomSelectInstance.setValue(this.fields[index].item_id || '');
                });
            }


        }
    };

</script>
