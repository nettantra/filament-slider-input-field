import noUiSlider from 'nouislider';
import 'nouislider/dist/nouislider.css'

const CHANGE_EVENT = 'change';
const EMPTY_MODIFER = 'empty';
const LAZY_MODIFIER = 'lazy';
const DEFER_MODIFIER = 'defer';

window.LivewireRangeSlider = function (data) {
    return {
        rangeSlider: null,
        models: [],
        modifier: EMPTY_MODIFER,
        handleHistory: null,
        init() {
            this.setup();
        },
        setup() {
            if(Object.hasOwn(this.$refs.range, 'noUiSlider'))
                return;

            noUiSlider.create(this.$refs.range, {
                ...data.options
            })

            this.rangeSlider = this.$refs.range.noUiSlider;

            this.rangeSlider.on(CHANGE_EVENT, 
                (values, handle) => this.handleUpdate(values, handle)
            ); 
        },
        handleUpdate(values, handle) {
            if (this.models[handle]  && this.modifier !== LAZY_MODIFIER) {
                this.$wire.set(
                    this.models[handle], values[handle], this.isDeferred()
                );
            }

            // Save handle index
            this.handleHistory = handle;
        },
        isLazy() {
            return this.modifier === LAZY_MODIFIER;
        },
        isDeferred() {
            return this.modifier === DEFER_MODIFIER;
        },
        getValue() {
            var model = this.models[this.handleHistory] ?? false;
            var value = this.rangeSlider.get()[this.handleHistory];

            if (this.isLazy() && model) {
                this.$wire.set(model, value);
            }
        },
        ...data
    }
}