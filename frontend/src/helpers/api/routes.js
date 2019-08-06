const apiServerUrl = 'http://127.0.0.1:8000';

export const userUrl = () =>
    `${apiServerUrl}/api/user`

export const formGetAttributeFieldsUrl = (typeId) =>
    `${apiServerUrl}/api/form/get-attribute-fields/type/${typeId}`