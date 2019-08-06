import {formGetAttributeFieldsUrl} from './routes';
import * as api from './api';

export const getAttributeFieldsUrl = (typeId) =>
    api.get(formGetAttributeFieldsUrl(typeId), {});