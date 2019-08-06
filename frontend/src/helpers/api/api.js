/**
 * Function for request GET
 * @param url
 */
export const get = (url, fields) =>
    new Promise(
        (resolve, reject) => {
            fetch(url+"?"+getParams(fields))
                .then(response => response.json())
                .then(json => resolve(json))
        }
    );

/**
 * Function send request
 * @param url
 * @param method
 * @param body
 * @param resolve
 * @param reject
 */
const apiCall = (url, method, body, resolve, reject) =>
    fetch(url, {
        method: method,
        headers: new Headers({
            'Content-Type': 'application/x-www-form-urlencoded'
        }),
        body: getParams(body)
    })
        .then(response => {
            if (response.ok) {
                response.json()
                    .then(json => resolve(json))
            } else {
                reject(response)
            }
        });

/**
 * Get the formated fields
 * @param body
 * @returns {string}
 */
const getParams = (body) => {
    var string = "";
    for(var i in body) {
        string = string + i + "=" + body[i] + "&";
    }

    return string;
};

/**
 * Function for request POST
 * @param url
 * @param body
 */
export const post = (url, body) =>
    new Promise(
        (resolve, reject) => apiCall(url, 'post', body, resolve, reject)
    );

/**
 * Function for request PUT
 * @param url
 * @param body
 */
export const put = (url, body) =>
    new Promise(
        (resolve, reject) => apiCall(url, 'put', body, resolve, reject)
    );

/**
 * Function for request DELETE
 * @param url
 * @param body
 */
export const deleteRequest = (url, body) =>
new Promise(
    (resolve, reject) => apiCall(url, 'delete', body, resolve, reject)
);