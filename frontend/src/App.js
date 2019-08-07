import React, {Component} from 'react';
import {BrowserRouter as Router,Route,Link} from 'react-router-dom';
import './styles/bootstrap.min.css';
import './styles/style.css';
import {Container, Nav} from 'react-bootstrap';
import UserForm from './components/form/UserForm';
import Admin from './components/admin/Admin';

class App extends Component {
  render() {
    return (
        <Container>
            <Nav variant="pills" defaultActiveKey={window.location.pathname}>
                <Nav.Item>
                    <Nav.Link href="/">Formularz rejestracyjny</Nav.Link>
                </Nav.Item>
                <Nav.Item>
                    <Nav.Link href="/admin">Panel administracyjny</Nav.Link>
                </Nav.Item>
            </Nav>
            <Router>
                <Route exact path="/" component={UserForm} />
                <Route path="/admin" component={Admin} />
            </Router>
        </Container>
    );
  }
}

export default App;
