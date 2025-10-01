<template>
    <div class="toggle-password-fieldtype">
        <div class="input-group">
            <text-input 
                :value="value" 
                @input="update" 
                :type="showPassword ? 'text' : 'password'"
                :placeholder="config.placeholder || 'Enter password'"
            />
            <button 
                type="button" 
                class="btn btn-sm btn-outline"
                @click="togglePassword"
                :title="showPassword ? 'Hide password' : 'Show password'"
            >
                <svg-icon :name="showPassword ? 'eye-off' : 'eye'" />
            </button>
        </div>
    </div>
</template>

<script>
export default {
    mixins: [Fieldtype],

    data() {
        return {
            showPassword: false
        };
    },

    methods: {
        togglePassword() {
            this.showPassword = !this.showPassword;
        }
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
