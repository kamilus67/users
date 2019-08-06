import {userUrl} from './routes';
import * as api from './api';

export const get = (userId) => {
    if(typeof userId !== 'undefined') {
        return api.get(userUrl() + '/' + userId, {})
    } else {
        return api.get(userUrl(), {});
    }
};

export const post = (data) =>
    api.post(userUrl(), {
        firstname: data.firstname,
        lastname: data.lastname,
        email: data.email,
        description: data.description,
        attributes: data.attributes
    });

export const put = (data) =>
    api.put(userUrl() + '/' + data.userId, {
        firstname: data.firstname,
        lastname: data.lastname,
        email: data.email,
        description: data.description,
        attributes: data.attributes
    });

export const deleteRequest = (userId) =>
    api.deleteRequest(userUrl() + '/' + userId, {});