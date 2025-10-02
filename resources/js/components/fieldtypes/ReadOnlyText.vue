<template>
    <div class="readonly-text-fieldtype">
        <input 
            type="text" 
            :value="value" 
            readonly 
            class="input-text"
            style="background-color: #f8f9fa; cursor: not-allowed;"
        />
        <div class="readonly-text-hint" v-if="config.instructions">
            <span>{{ config.instructions }}</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['value', 'config'],
    
    computed: {
        displayText() {
            const text = this.value || this.config.default_text || 'No text configured';
            const style = this.config.text_style || 'normal';
            
            switch (style) {
                case 'italic':
                    return `<em>${text}</em>`;
                case 'bold':
                    return `<strong>${text}</strong>`;
                case 'muted':
                    return `<span style="color: #6c757d;">${text}</span>`;
                case 'success':
                    return `<span style="color: #28a745;">${text}</span>`;
                case 'warning':
                    return `<span style="color: #ffc107;">${text}</span>`;
                case 'error':
                    return `<span style="color: #dc3545;">${text}</span>`;
                default:
                    return text;
            }
        }
    },

    mounted() {
        if (this.config.default_text) {
            this.$emit('input', this.config.default_text);
        }
    }
};
</script>

<style scoped>
.readonly-text-fieldtype {
    padding: 12px;
    background-color: #f8f9fa;
    border-radius: 4px;
    position: relative;
}

.readonly-text-fieldtype.has-border {
    border: 1px solid #e9ecef;
}

.readonly-text-content {
    font-size: 14px;
    line-height: 1.5;
    color: #495057;
    margin-bottom: 8px;
}

.readonly-text-content :deep(.text-muted) {
    color: #6c757d;
}

.readonly-text-content :deep(.text-success) {
    color: #28a745;
}

.readonly-text-content :deep(.text-warning) {
    color: #ffc107;
}

.readonly-text-content :deep(.text-error) {
    color: #dc3545;
}

.readonly-text-hint {
    display: flex;
    align-items: center;
    font-size: 12px;
    color: #6c757d;
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid #e9ecef;
}

.hint-icon {
    width: 14px;
    height: 14px;
    margin-right: 6px;
    flex-shrink: 0;
}

/* Override any input styling that might be applied */
.readonly-text-fieldtype input {
    display: none !important;
}

.readonly-text-fieldtype textarea {
    display: none !important;
}
</style>