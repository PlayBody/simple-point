import React from "react";
// nodejs library to set properties for components
import PropTypes from "prop-types";
import cx from "classnames";

import { connect } from 'react-redux';
import * as authAction from 'redux/actions/auth';
import * as storageService from '../../services/storageService';
import { Router, Route, Switch, Redirect, withRouter } from "react-router-dom";
import SweetAlert from "react-bootstrap-sweetalert";

// @material-ui/core components
import { makeStyles } from "@material-ui/core/styles";
import Button from "components/CustomButtons/Button.js";
import logo from "assets/img/auth_logo.png";
import Slide from "@material-ui/core/Slide";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import DialogActions from "@material-ui/core/DialogActions";

import styles from "assets/jss/material-dashboard-pro-react/components/adminNavbarStyle.js";

const useStyles = makeStyles(styles);

const Transition = React.forwardRef(function Transition(props, ref) {
  return <Slide direction="down" ref={ref} {...props} />;
});

const AdminNavbar = (props) => {

  const [logoutModal, setLogoutModal] = React.useState(false);

  const classes = useStyles();
  const { color, rtlActive, brandText } = props;
  const appBarClasses = cx({
    [" " + classes[color]]: color
  });
  const sidebarMinimize =
    classes.sidebarMinimize +
    " " +
    cx({
      [classes.sidebarMinimizeRTL]: rtlActive
    });

    const handleLogOut = () => {
      props.logout()
      storageService.removeStorage('token')
      storageService.removeStorage('user')
      props.history.push("/auth/login");
    }
  return (
    <div className={classes.topbar}>
       <Dialog
        classes={{
          root: classes.center + " " + classes.modalRoot,
          paper: classes.modal
        }}
        open={logoutModal}
        TransitionComponent={Transition}
        keepMounted
        onClose={() => setLogoutModal(false)}
        aria-labelledby="classic-modal-slide-title"
        aria-describedby="classic-modal-slide-description"
      >
        <DialogTitle
          id="classic-modal-slide-title"
          disableTypography
          className={classes.modalHeader}
        >
          <h4><b>??????????????????????????????</b></h4>
        </DialogTitle>
        <DialogActions
          className={
            classes.modalFooter + " " + classes.modalFooterCenter
          }
        >
          <Button
            onClick={() => setLogoutModal(false)}
            color="transparent"
            className={classes.modalSmallFooterFirstButton}
          >
            ???????????????
          </Button>
          <Button
            onClick={() => handleLogOut()}
            color="danger"
            simple
            className={
              classes.modalSmallFooterFirstButton +
              " " +
              classes.modalSmallFooterSecondButton
            }
          >
            ???????????????
          </Button>
        </DialogActions>            
      </Dialog>
      <img src={logo} alt="..." width="150px"/>
      <span
        style={{ fontSize: "18px", fontWeight: "bold", position: "absolute", right: "140px", top: "20px" }}
      >{props.user.name}</span>
      <Button style={{ 
        backgroundColor: "red",
        paddingTop: "5px",
        paddingBottom: "5px",
        paddingLeft: "15px",
        paddingRight: "15px",
        position: "absolute",
        right: "20px"
    }} 
    onClick={() => setLogoutModal(true)}
    >
      ???????????????
      </Button>
    </div>
  );
}

const mapStateToProps = (state, ownProps) => ({
  user: state.auth.user
})

const mapDispatchToProps = ({
  logout: authAction.Logout,
})

export default connect(mapStateToProps, mapDispatchToProps)(withRouter(AdminNavbar))