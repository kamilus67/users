import React, {Component} from 'react';
import {Row,Breadcrumb, Form, Button, Alert, Table, ButtonToolbar, Modal} from 'react-bootstrap';
import * as userApi from '../../helpers/api/userApi';
import * as formApi from '../../helpers/api/formApi';

class Admin extends Component {
    constructor() {
        super();
        this.state = {
            users_collection: [],
            alert_show: false,
            alert_content: '',
            alert_type: 'denger',
            modal: {
                show: false,
                title: ''
            },
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
            userId: null
        }
    }

    componentDidMount = async () => {
        const usersCollection = await userApi.get();
        const options = await formApi.getOptions();

        this.setState({
            users_collection: usersCollection.content,
            options: options.content
        });
    }

    showModalToUpdate = async (id) => {
        const user = await userApi.get(id);

        if(user.result === true) {
            const userData = user.content[0];
            const stanowisko  = userData.attributes.stanowisko.value;
            this.setState({
                userId: userData.id,
                firstname: userData.firstname,
                lastname: userData.lastname,
                email: userData.email,
                description: userData.description,
                attribute_stanowisko: userData.attributes.stanowisko.value,
                attribute_systemy_testujace: (stanowisko == '1') ? userData.attributes.systemy_testujace.value : '',
                attribute_systemy_raportowe: (stanowisko == '1' || stanowisko == '3') ? userData.attributes.systemy_raportowe.value : '',
                attribute_zna_selenium: (stanowisko == '1') ? userData.attributes.zna_selenium.value : '',
                attribute_srodowiska_ide: (stanowisko == '2') ? userData.attributes.srodowiska_ide.value : '',
                attribute_jezyki_programowania: (stanowisko == '2') ? userData.attributes.jezyki_programowania.value : '',
                attribute_zna_mysql: (stanowisko == '2') ? userData.attributes.zna_mysql.value : '',
                attribute_metodologie_prowadzenia_projektow: (stanowisko == '3') ? userData.attributes.metodologie_prowadzenia_projektow.value : '',
                attribute_zna_scrum: (stanowisko == '3') ? userData.attributes.zna_scrum.value : '',
            });

            this.setState({
                modal: {
                    show: true,
                    title: 'Edycja użytkownika',
                }
            });
        } else {
            this.setState({
                alert_show: true,
                alert_type: 'danger'
            });

            setTimeout(function() {
                this.setState({
                    alert_show: false,
                });
            }.bind(this), 5000);
        }
    }

    deleteItem = async (id) => {
        const result = await userApi.deleteRequest(id);

        let message = '';
        let alertType = '';

        if(result.result === true) {
            message = 'Usunięto użytkownika!';
            alertType = 'success';
            document.getElementById("user-"+id).remove();
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

        if(this.state.attribute_stanowisko == '1') {
            attribute = {
                systemy_testujace: this.state.attribute_systemy_testujace,
                systemy_raportowe: this.state.attribute_systemy_raportowe,
                zna_selenium: (this.state.attribute_zna_selenium) ? '1' : '0',
                stanowisko: this.state.attribute_stanowisko
            };
        } else if(this.state.attribute_stanowisko == '2') {
            attribute = {
                srodowiska_ide: this.state.attribute_srodowiska_ide,
                jezyki_programowania: this.state.attribute_jezyki_programowania,
                zna_mysql: (this.state.attribute_zna_mysql) ? '1' : '0',
                stanowisko: this.state.attribute_stanowisko
            };
        } else if(this.state.attribute_stanowisko == '3') {
            attribute = {
                metodologie_prowadzenia_projektow: this.state.attribute_metodologie_prowadzenia_projektow,
                systemy_raportowe: this.state.attribute_systemy_raportowe,
                zna_scrum: (this.state.attribute_zna_scrum) ? '1' : '0',
                stanowisko: this.state.attribute_stanowisko
            };
        }

        const result = await userApi.put({
            userId: this.state.userId,
            firstname: this.state.firstname,
            lastname: this.state.lastname,
            email: this.state.email,
            description: this.state.description,
            attribute: attribute
        });

        let message = '';
        let alertType = '';
        if(result.result === true) {
            message = 'Zaaktualizowano użytkownika!';
            alertType = 'success';
            this.closeModal();
            this.updateRow();
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

    updateRow = () => {
        const id = this.state.userId;

        document.getElementById("user-" + id).cells[0].innerHTML = this.state.firstname;
        document.getElementById("user-" + id).cells[1].innerHTML = this.state.lastname;
        document.getElementById("user-" + id).cells[2].innerHTML = this.state.email;
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

    closeModal = () => {
        this.setState({
            modal: {
                show: false,
                title: '',
                content: ''
            }
        });
    }

    render() {
        return(
            <div>
                <Breadcrumb>
                    <Breadcrumb.Item>Aplikacja na rekrutację</Breadcrumb.Item>
                    <Breadcrumb.Item>Panel administracyjny</Breadcrumb.Item>
                </Breadcrumb>
                <Alert show={this.state.alert_show} variant={this.state.alert_type}>{this.state.alert_content}</Alert>
                <Table striped bordered hover>
                    <thead>
                        <tr>
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Email</th>
                            <th>Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        {this.state.users_collection.map(item => <tr id={"user-"+item.id}>
                            <td>{item.firstname}</td>
                            <td>{item.lastname}</td>
                            <td>{item.email}</td>
                            <td>
                                <ButtonToolbar className="d-flex justify-content-around">
                                    <Button variant="primary" onClick={() => this.showModalToUpdate(item.id)}>Edytuj</Button>
                                    <Button variant="danger" onClick={() => this.deleteItem(item.id)}>Usuń</Button>
                                </ButtonToolbar>
                            </td>
                        </tr>)}
                    </tbody>
                </Table>
                <Modal size="lg" aria-labelledby="contained-modal-title-vcenter" centered show={this.state.modal.show}>
                    <Modal.Header closeButton onClick={this.closeModal}>
                        <Modal.Title id="contained-modal-title-vcenter">
                            {this.state.modal.title}
                        </Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <Form id="form1" onSubmit={this.submitForm}>
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
                                <Form.Control as="select" onChange={this.selectUpdate} value={this.state.attribute_stanowisko} disabled>
                                    {this.state.options.map(item => <option value={item.value}>{item.label}</option>)}
                                </Form.Control>
                                <Form.Text>
                                    Nie można zmienić tej informacji
                                </Form.Text>
                            </Form.Group>
                            <section className={(this.state.attribute_stanowisko == '1') ? 'd-block' : 'd-none'}>
                                <Form.Group>
                                    <Form.Label>Systemy testujące</Form.Label>
                                    <Form.Control type="text" name="attribute_systemy_testujace" placeholder="Systemy testujące" onChange={this.updateField} value={this.state.attribute_systemy_testujace} />
                                </Form.Group>
                                <Form.Group>
                                    <Form.Label>Systemy raportowe</Form.Label>
                                    <Form.Control type="text" name="attribute_systemy_raportowe" placeholder="Systemy raportowe" onChange={this.updateField} value={this.state.attribute_systemy_raportowe} />
                                </Form.Group>
                                <Form.Group>
                                    <Form.Check type="checkbox" name="attribute_zna_selenium" label="Zna selenium" onChange={this.updateChecked} checked={(this.state.attribute_zna_selenium == '1') ? true : false}/>
                                </Form.Group>
                            </section>
                            <section className={(this.state.attribute_stanowisko == '2') ? 'd-block' : 'd-none'}>
                                <Form.Group>
                                    <Form.Label>Środowiska IDE</Form.Label>
                                    <Form.Control type="text" name="attribute_srodowiska_ide" placeholder="Środowiska IDE" onChange={this.updateField} value={this.state.attribute_srodowiska_ide} />
                                </Form.Group>
                                <Form.Group>
                                    <Form.Label>Języki programowania</Form.Label>
                                    <Form.Control type="text" name="attribute_jezyki_programowania" placeholder="Języki programowania" onChange={this.updateField} value={this.state.attribute_jezyki_programowania} />
                                </Form.Group>
                                <Form.Group>
                                    <Form.Check type="checkbox" name="attribute_zna_mysql" label="Zna MySQL" onChange={this.updateChecked} checked={(this.state.attribute_zna_mysql == '1') ? true : false} />
                                </Form.Group>
                            </section>
                            <section className={(this.state.attribute_stanowisko == '3') ? 'd-block' : 'd-none'}>
                                <Form.Group>
                                    <Form.Label>Metodologie prowadzenia projektów</Form.Label>
                                    <Form.Control type="text" name="attribute_metodologie_prowadzenia_projektow" placeholder="Metodologie prowadzenia projektów" onChange={this.updateField} value={this.state.attribute_metodologie_prowadzenia_projektow} />
                                </Form.Group>
                                <Form.Group>
                                    <Form.Label>Systemy raportowe</Form.Label>
                                    <Form.Control type="text" name="attribute_systemy_raportowe" placeholder="Systemy raportowe" onChange={this.updateField} value={this.state.attribute_systemy_raportowe} />
                                </Form.Group>
                                <Form.Group>
                                    <Form.Check type="checkbox" name="attribute_zna_scrum" label="Zna Scrum" onChange={this.updateChecked} checked={(this.state.attribute_zna_scrum == '1') ? true : false} />
                                </Form.Group>
                            </section>
                        </Form>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="primary" type="submit" form="form1">Zapisz zmiany</Button>
                        <Button onClick={this.closeModal}>Anuluj</Button>
                    </Modal.Footer>
                </Modal>
            </div>
        );
    }
}

export default Admin