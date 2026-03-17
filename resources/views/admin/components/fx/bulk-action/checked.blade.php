<input {{ $attributes }}
    class="form-check-input align-middle m-1"
       type="checkbox"
       x-model="checkedAll"
       x-on:click="toggleCheckedAll()"
/>
