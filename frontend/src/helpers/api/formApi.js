import {formGetAttributeFieldsUrl, formGetOptions} from './routes';
import * as api from './api';

export const getOptions = () =>
    api.get(formGetOptions(), {});