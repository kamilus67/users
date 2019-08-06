import React, {Component} from 'react';
import {Row,Breadcrumb, Form, Button, Alert} from 'react-bootstrap';
import * as userApi from '../../helpers/api/userApi';
import * as formApi from '../../helpers/api/formApi';

class UserForm extends Component {
    constructor() {
        super();
        this.state = {
            options: [],
            firstname: '',
            lastname: '',
            email: '',
            description: '',
            attribute_stanowisko: null,
            attribute_systemy_testujace: '',
            attribute_systemy_raportowe: '',
            attribute_zna_selenium: '',
            attribute_srodowiska_ide: '',
            attribute_jezyki_programowania: '',
            attribute_zna_mysql: '',
            attribute_metodologie_prowadzenia_projektow: '',
            attribute_zna_scrum: '',
            alert_show: false,
            alert_content: '',
            alert_type: 'denger'
        }
    }

    componentDidMount = async () => {
        const options = await formApi.getOptions();

        this.setState({
            options: options.content
        });
    }

    selectUpdate = (event) => {
        this.setState({
            attribute_stanowisko: event.target.value
        });
    }

    updateField = (event) => {
        this.setState({[event.target.name]: event.target.value});
        console.log(event.target.checked);
    }

    updateChecked = (event) => {
        this.setState({[event.target.name]: event.target.checked});
    }

    submitForm = async (event) => {
        event.preventDefault();

        if(this.state.firstname.length === 0 || this.state.lastname.length === 0 || this.state.email.length === 0) {
            this.setState({
                alert_show: true,
                alert_content: 'Uzupełnij wszystkie wymagane pola',
                alert_type: 'danger'
            });

            setTimeout(function() {
                this.setState({
                    alert_show: false,
                    alert_content: ''
                });
            }.bind(this), 5000);
        }

        let attribute = {};

        if(this.state.attribute_stanowisko === '1') {
            attribute = {
                systemy_testujace: this.state.attribute_systemy_testujace,
                systemy_raportowe: this.state.attribute_systemy_raportowe,
                zna_selenium: (this.state.attribute_zna_selenium) ? '1' : '0',
                stanowisko: this.state.attribute_stanowisko
            };
        } else if(this.state.attribute_stanowisko === '2') {
            attribute = {
                srodowiska_ide: this.state.attribute_srodowiska_ide,
                jezyki_programowania: this.state.attribute_jezyki_programowania,
                zna_mysql: (this.state.attribute_zna_mysql) ? '1' : '0',
                stanowisko: this.state.attribute_stanowisko
            };
        } else if(this.state.attribute_stanowisko === '3') {
            attribute = {
                metodologie_prowadzenia_projektow: this.state.attribute_metodologie_prowadzenia_projektow,
                systemy_raportowe: this.state.attribute_systemy_raportowe,
                zna_scrum: (this.state.attribute_zna_scrum) ? '1' : '0',
                stanowisko: this.state.attribute_stanowisko
            };
        }

        const result = await userApi.post({
            firstname: this.state.firstname,
            lastname: this.state.lastname,
            email: this.state.email,
            description: this.state.description,
            attribute: attribute
        });

        let message = '';
        let alertType = '';
        if(result.result === true) {
            message = 'Dodano użytkownika!';
            alertType = 'success';
            this.clearForm();
        } else {
            message = result.message;
            alertType = 'danger';
        }

        this.setState({
            alert_show: true,
            alert_content: message,
            alert_type: alertType
        });

        setTimeout(function() {
            this.setState({
                alert_show: false,
                alert_content: ''
            });
        }.bind(this), 5000);
    }

    clearForm = () => {
        this.setState({
            firstname: '',
            lastname: '',
            email: '',
            description: '',
            attribute_stanowisko: null,
            attribute_systemy_testujace: '',
            attribute_systemy_raportowe: '',
            attribute_zna_selenium: '',
            attribute_srodowiska_ide: '',
            attribute_jezyki_programowania: '',
            attribute_zna_mysql: '',
            attribute_metodologie_prowadzenia_projektow: '',
            attribute_zna_scrum: ''
        });
    }

    render() {
        return(
            <div>
                <Breadcrumb>
                    <Breadcrumb.Item>Formularz rejestracyjny</Breadcrumb.Item>
                </Breadcrumb>
                <Alert show={this.state.alert_show} variant={this.state.alert_type}>{this.state.alert_content}</Alert>
                <Form onSubmit={this.submitForm}>
                    <Form.Group>
                        <Form.Label>Imię</Form.Label>
                        <Form.Control type="text" name="firstname" placeholder="Imię" onChange={this.updateField} value={this.state.firstname} />
                    </Form.Group>
                    <Form.Group>
                        <Form.Label>Nazwisko</Form.Label>
                        <Form.Control type="text" name="lastname" placeholder="Nazwisko" onChange={this.updateField} value={this.state.lastname} />
                    </Form.Group>
                    <Form.Group>
                        <Form.Label>Email</Form.Label>
                        <Form.Control type="email" name="email" placeholder="Email" onChange={this.updateField} value={this.state.email} />
                    </Form.Group>
                    <Form.Group>
                        <Form.Label>Opis</Form.Label>
                        <Form.Control as="textarea" name="description" placeholder="Opis" onChange={this.updateField} value={this.state.description} />
                    </Form.Group>
                    <Form.Group>
                        <Form.Label>Stanowisko</Form.Label>
                        <Form.Control as="select" onChange={this.selectUpdate} value={this.state.attribute_stanowisko}>
                            <option selected disabled>Wybierz</option>
                            {this.state.options.map(item => <option value={item.value}>{item.label}</option>)}
                        </Form.Control>
                    </Form.Group>
                    <section className={(this.state.attribute_stanowisko === '1') ? 'd-block' : 'd-none'}>
                        <Form.Group>
                            <Form.Label>Systemy testujące</Form.Label>
                            <Form.Control type="text" name="attribute_systemy_testujace" placeholder="Systemy testujące" onChange={this.updateField} value={this.props.attribute_systemy_testujace} />
                        </Form.Group>
                        <Form.Group>
                            <Form.Label>Systemy raportowe</Form.Label>
                            <Form.Control type="text" name="attribute_systemy_raportowe" placeholder="Systemy raportowe" onChange={this.updateField} value={this.props.attribute_systemy_raportowe} />
                        </Form.Group>
                        <Form.Group>
                            <Form.Check type="checkbox" name="attribute_zna_selenium" label="Zna selenium" onChange={this.updateChecked} />
                        </Form.Group>
                    </section>
                    <section className={(this.state.attribute_stanowisko === '2') ? 'd-block' : 'd-none'}>
                        <Form.Group>
                            <Form.Label>Środowiska IDE</Form.Label>
                            <Form.Control type="text" name="attribute_srodowiska_ide" placeholder="Środowiska IDE" onChange={this.updateField} value={this.props.attribute_srodowiska_ide} />
                        </Form.Group>
                        <Form.Group>
                            <Form.Label>Języki programowania</Form.Label>
                            <Form.Control type="text" name="attribute_jezyki_programowania" placeholder="Języki programowania" onChange={this.updateField} value={this.props.attribute_jezyki_programowania} />
                        </Form.Group>
                        <Form.Group>
                            <Form.Check type="checkbox" name="attribute_zna_mysql" label="Zna MySQL" onChange={this.updateChecked} />
                        </Form.Group>
                    </section>
                    <section className={(this.state.attribute_stanowisko === '3') ? 'd-block' : 'd-none'}>
                        <Form.Group>
                            <Form.Label>Metodologie prowadzenia projektów</Form.Label>
                            <Form.Control type="text" name="attribute_metodologie_prowadzenia_projektow" placeholder="Metodologie prowadzenia projektów" onChange={this.updateField} value={this.props.attribute_metodologie_prowadzenia_projektow} />
                        </Form.Group>
                        <Form.Group>
                            <Form.Label>Systemy raportowe</Form.Label>
                            <Form.Control type="text" name="attribute_systemy_raportowe" placeholder="Systemy raportowe" onChange={this.updateField} value={this.props.attribute_systemy_raportowe} />
                        </Form.Group>
                        <Form.Group>
                            <Form.Check type="checkbox" name="attribute_zna_scrum" label="Zna Scrum" onChange={this.updateChecked} />
                        </Form.Group>
                    </section>
                    <Button variant="primary" type="submit">Zapisz</Button>
                </Form>
            </div>
        );
    }
}

export default UserForm