import axios from 'axios';

import ActionTypes from './actionTypes';

export function Signin(user) {
  return dispatch => dispatch({ type: ActionTypes.signin, payload: user })
}

export function Signup(user) {
  return dispatch => dispatch({ type: ActionTypes.signup, payload: user })
}

export function RecoverPass(user) {
  return dispatch => dispatch({ type: ActionTypes.recoverpass, payload: user })
}

export function Logout() {
  return dispatch => dispatch({ type: ActionTypes.logout })
}

