import React, {Component} from 'react';
import {Row,Breadcrumb, Form, Button} from 'react-bootstrap';

class UserForm extends Component {
    constructor() {
        super();
        this.state = {
            attributes: {}
        }
    }

    render() {
        return(
            <div>
                <Breadcrumb>
                    <Breadcrumb.Item>Formularz rejestracyjny</Breadcrumb.Item>
                </Breadcrumb>
                <Form>
                    <Form.Group>
                        <Form.Label>Imię</Form.Label>
                        <Form.Control type="text" placeholder="Imię" />
                    </Form.Group>
                    <Form.Group>
                        <Form.Label>Nazwisko</Form.Label>
                        <Form.Control type="text" placeholder="Nazwisko" />
                    </Form.Group>
                    <Form.Group>
                        <Form.Label>Email</Form.Label>
                        <Form.Control type="email" placeholder="Email" />
                    </Form.Group>
                    <Form.Group>
                        <Form.Label>Opis</Form.Label>
                        <Form.Control as="textarea" placeholder="Opis" />
                    </Form.Group>
                    <Button variant="primary" type="submit">Zapisz</Button>
                </Form>
            </div>
        );
    }
}

export default UserForm