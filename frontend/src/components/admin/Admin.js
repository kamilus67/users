import React, {Component} from 'react';
import * as userApi from '../../helpers/api/userApi';
import * as formApi from '../../helpers/api/formApi';

class Admin extends Component {
    componentDidMount = async () => {
        const usersCollection = await userApi.get();
        const formFields = await formApi.getAttributeFieldsUrl(1);
    }

    render() {
        return(
            <div>Admin</div>
        );
    }
}

export default Admin