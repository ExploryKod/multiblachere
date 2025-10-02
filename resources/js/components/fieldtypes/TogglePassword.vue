<template>
    <div>
        <input 
            :type="show ? 'text' : 'password'" 
            :value="value" 
            @input="$emit('input', $event.target.value)"
            :placeholder="config.placeholder || 'Enter password'"
        />
        <label>
            <input type="checkbox" v-model="show" /> 
            Show Password
        </label>
    </div>
</template>

<script>
export default {
    props: ['value', 'config'],
    
    data() {
        return {
            show: false
        };
    }
};
</script>

<style scoped>
.toggle-password-fieldtype .input-group {
    display: flex;
    align-items: center;
}

.toggle-password-fieldtype .input-group .text-input {
    flex: 1;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-right: 0;
}

.toggle-password-fieldtype .input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-left: 0;
    height: 100%;
    min-height: 32px;
}
</style>
