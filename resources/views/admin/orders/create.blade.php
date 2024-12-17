@extends('layouts.'.tenant()->id.'/admin')
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
            {{ trans(tenant()->id.'/global.create') }} {{ trans(tenant()->id.'/cruds.order.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group col-md-4 ">
                <label class="required" for="member_id">{{ trans(tenant()->id.'/cruds.order.fields.member') }}</label>
                <select class="form-control {{ $errors->has('member') ? 'is-invalid' : '' }}" name="member_id" id="member_id" required>
                    <option value="">Please select</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ $member->membership_no }}-{{ $member->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('member'))
                <div class="invalid-feedback">
                    {{ $errors->first('member') }}
                </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.order.fields.member_helper') }}</span>
            </div>

            

            <div class="form-group col-md-4">
                <label class="required" for="user_id">Table Top</label>
                <select class="form-control {{ $errors->has('table') ? 'is-invalid' : '' }}" name="table_top_id" id="table_top_id" required>
                    @foreach($tableTops as $id => $entry)
                    <option value="{{ $id }}" {{ old('table_top_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('table'))
                <div class="invalid-feedback">
                    {{ $errors->first('table') }}
                </div>
                @endif
                <span class="help-block"></span>
            </div>

            <div class="form-group col-md-4">
                <label class="required" for="name">No of Guests</label>
                <input class="form-control {{ $errors->has('no_of_guests') ? 'is-invalid' : '' }}" type="number" name="no_of_guests" id="no_of_guests" value="{{ old('no_of_guests', '') }}" required>
                @if($errors->has('no_of_guests'))
                <div class="invalid-feedback">
                    {{ $errors->first('no_of_guests') }}
                </div>
                @endif
                <span class="help-block"></span>
            </div>



            <div class="card-body row" x-data="handler()">

                <div class="col-md-12">
                    <label for="photo">Select Items</label>
                    <table class="table table-bordered align-items-center table-sm">
                        <thead >
                            <tr>
                                <th>#</th>
                                <th>Menu</th>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(field, index) in fields" :key="index">
                                <tr>
                                    <td x-text="index + 1"></td>
                                    <td>
                                        <select required x-model="field.menu_id" x-on:change="getItems(index)"  class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" :name="`items[${index}][menu_id]`" :id="`menu_id_${index}`">
                                            @foreach($menus as $id => $entry)
                                                <option value="{{ $id }}" x-bind:selected="field.menu_id == '{{ $id }}' ? true : false">{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select required x-model="field.item_id" x-on:change="getPrice(index)" class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" :name="`items[${index}][item_id]`" :id="`item_id_${index}`">
                                            <option>Please select</option>
                                            <template x-for="item in field.items">
                                                <option x-text="item.title" x-bind:value="item.id"></option>
                                            </template>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" x-model="field.price" :name="`items[${index}][price]`">
                                        <input required x-model="field.price" readonly class="form-control">
                                    </td>
                                    <td>
                                        <input required x-model="field.quantity" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" :name="`items[${index}][quantity]`" id="quantity" >
                                    </td>
                                    

                                    <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                                </tr>
                            </template>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Add Item</button></td>
                            </tr>

                        </tfoot>
                    </table>
                </div>

            </div>

            {{-- <div class="form-group col-md-4">
                <label class="required" for="user_id">{{ trans(tenant()->id.'/cruds.order.fields.user') }}</label>
            <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                @foreach($users as $id => $entry)
                <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                @endforeach
            </select>
            @if($errors->has('user'))
            <div class="invalid-feedback">
                {{ $errors->first('user') }}
            </div>
            @endif
            <span class="help-block">{{ trans(tenant()->id.'/cruds.order.fields.user_helper') }}</span>
    </div> --}}

    <div class="form-group col-md-4">
        <label class="required">{{ trans(tenant()->id.'/cruds.order.fields.status') }}</label>
        <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
            <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
            @foreach(App\Models\Order::STATUS_SELECT as $key => $label)
                @if ($key == App\Models\Order::STATUS_SELECT['Active'])
                    <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                @endif
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
        <button class="btn btn-success px-5" type="submit">
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

    new TomSelect("#table_top_id", {
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });

    new TomSelect("#menu_id_0", {
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });

    // new TomSelect("#item_id", {
    //     create: true,
    //     sortField: {
    //         field: "text",
    //         direction: "asc"
    //     }
    // });
});

</script>

<script>
    function handler() {

        return {
            globalIndex:0,
            tomSelectInstances:[],
            fields: [{
                item_id: '',
                menu_id: '', 
                price: '', 
                quantity: '',
                items:[],
            }],
            initTomSelect(index) {
                
                this.$nextTick(() => {
                    const menuId = `menu_id_${index}`;
                    this.tomSelectInstances[menuId] = new TomSelect(`#${menuId}`, {
                        onChange: (value) => {
                            this.fields[index].menu_id = value; 
                        }
                    });
                });
            }
            , addNewField() {
                this.fields.push({
                    // item_id: '',
                    menu_id: '', 
                    price: '', 
                    quantity: ''
                });
                this.globalIndex = this.globalIndex + 1;
                this.initTomSelect(this.globalIndex)
            }
            , removeField(index) {
                this.fields.splice(index, 1);
                this.globalIndex = this.globalIndex - 1;
            },

            async getPrice(index) {

                let data = await (await fetch("{{ route('admin.items.getById') }}?item_id=" + this.fields[index].item_id)).json();
                this.fields[index].price = data.item.price;
            },

            calculateAmount(index) {
                if (this.fields[index].quantity) {
                    this.fields[index].total_amount = this.fields[index].quantity * this.fields[index].unit_rate;
                }

                this.grand_total = this.fields.reduce((accumulator, object) => {
                    return accumulator + object.total_amount;
                }, 0);
            },
            async getItems(index) {

            
                let data = await (await fetch("{{ route('admin.items.getItemByMenu') }}?menu_id=" + this.fields[index].menu_id)).json();
                this.fields[index].items = data.item;

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
                    
                    data.item.forEach(item => {
                        tomSelectInstance.addOption({ value: item.id, text: item.title });
                    });

                    // Optionally set the value if you want to select a default one
                    tomSelectInstance.setValue(this.fields[index].item_id || '');
                });
                
                
            } // close async getItems


        }
    };

</script>
