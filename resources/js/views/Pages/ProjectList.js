import React, { useEffect } from "react";
import { connect } from 'react-redux';
import { withRouter } from "react-router-dom";
import { makeStyles } from "@material-ui/core/styles";

import AttachFileOutlinedIcon from '@material-ui/icons/AttachFileOutlined';

import * as userService from 'services/userService';
import * as projectService from 'services/projectService';

import GridContainer from "components/Grid/GridContainer.js";
import GridItem from "components/Grid/GridItem.js";
import Table from "components/Table/Table.js";
import Button from "components/CustomButtons/Button.js";
import Button1 from "components/CustomButtons/Button1.js";
import Button2 from "components/CustomButtons/Button2.js";
import Card from "components/Card/Card.js";
import CardBody from "components/Card/CardBody.js";
import Slide from "@material-ui/core/Slide";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import DialogContent from "@material-ui/core/DialogContent";
import DialogActions from "@material-ui/core/DialogActions";

import styles from "../Components/style/mainStyle";

const useStyles = makeStyles(styles);

const Transition = React.forwardRef(function Transition(props, ref) {
  return <Slide direction="down" ref={ref} {...props} />;
});

const ProjectList = ({user,history}) => {

    const [asignProjectModal, setAsignProjectModal] = React.useState(false);
    const [deleteProjectModal, setDeleteProjectModal] = React.useState(false);
    const [businessData, setBusinessData] = React.useState([]);

    const orderButtons = [
        { color: "rose", icon: AttachFileOutlinedIcon },
      ].map((prop, key) => {
        return (
          <Button
            color={prop.color}
            simple
            key={key}
          >
            <prop.icon />
          </Button>
        );
      });

      const invoiceButtons = [
        { color: "rose", icon: AttachFileOutlinedIcon },
      ].map((prop, key) => {
        return (
          <Button
            color={prop.color}
            simple
            key={key}
          >
            <prop.icon />
          </Button>
        );
      });

      const asignButtons = [
        { color: "rose"},
      ].map((prop, key) => {
        return (
          <Button2
            color={prop.color}
            simple
            key={key}
            onClick={() => setAsignProjectModal(true)}
          >
           割当
          </Button2>
        );
      });
    
      const removeProjectsButtons = [
        { color: "rose"},
      ].map((prop, key) => {
        return (
          <Button2
            color={prop.color}
            simple
            key={key}
            style={{ padding: "none" }}
            onClick={() => setDeleteProjectModal(true)}
          >
           削除
          </Button2>
        );
      });
    
    const [projectsTableData, setProjectsTableData] = React.useState([]);

    useEffect(() => {
        projectService.getProjects().then(res => {
            console.log('------- role: ', res.data.projects, user.roles[0].id)
            if (res.data.projects){
                setProjectsTableData(res.data.projects.map((project, index) => {
                    switch (user.roles[0].id) {
                        case 1:   // Admin
                            return [index+1, project.title, project.client.company, project.amount,  project.delivery_date, project.delivery_date, project.status, asignButtons, removeProjectsButtons,
                            <Button2
                            color="rose"
                            simple
                              onClick={() => {
                                let obj = res.data.projects.find(o => o.id === project.id);
                                history.push("/admin/projectdetail/" + obj.id + "");
                              }}
                            >detail</Button2>
                          ]
                        case 2:   // Client
                            return [index+1, project.title, project.amount, project.delivery_date, project.delivery_date, orderButtons, invoiceButtons, project.status,
                            <Button2
                            color="rose"
                            simple
                              onClick={() => {
                                let obj = res.data.projects.find(o => o.id === project.id);
                                history.push("/admin/projectdetail/" + obj.id + "");
                              }}
                            >detail</Button2>
                          ]
                        case 3:   // Business
                            return [index+1, project.title, project.delivery_date, project.delivery_date, project.status,
                            <Button2
                            color="rose"
                            simple
                              onClick={() => {
                                let obj = res.data.projects.find(o => o.id === project.id);
                                history.push("/admin/projectdetail/" + obj.id + "");
                              }}
                            >detail</Button2>
                          ]
                        default:
                            break;
                    }
                }))
            }
            else {
            console.log('error');
            }
        }).catch((err)=>{
          console.log(err);
      })

      user.roles[0].id == 1 && userService.getBusinesspeople().then(result => {
        console.log(result.data, 'businesses')
        if(result.data.businesses){
          setBusinessData(result.data.businesses.map((businessman, key) => {
            return[key+1, businessman.name]
          }))
        }
        else{
          console.log('error');
        }
      }).catch((err)=>{
        console.log(err);
      })
    }, [])

    const classes = useStyles();

    return (
        <div>
            <Dialog
              classes={{
                root: classes.center + " " + classes.modalRoot,
                paper: classes.modal
              }}
              open={asignProjectModal}
              TransitionComponent={Transition}
              keepMounted
              onClose={() => setAsignProjectModal(false)}
              aria-labelledby="classic-modal-slide-title"
              aria-describedby="classic-modal-slide-description"
            >
              <DialogTitle
                id="classic-modal-slide-title"
                disableTypography
                className={classes.modalHeader}
              >
                <h4><b>割当アカウントを選択してください</b></h4>
              </DialogTitle>
              <DialogContent
                id="classic-modal-slide-description"
                className={classes.modalBody}
              >
                {/* {businessData} */}
                {businessData.map((arr, key) => {
                  return (
                  <GridContainer justify="center" key={key} style={{borderBottom: "1px solid lightgrey", marginBottom: "20px"}}>
                    <GridItem xs={12} sm={6}>{arr[1]}</GridItem>
                    <GridItem xs={12} sm={6}>
                      <Button1 style={{ backgroundColor: "red" }} 
                        // onClick={() => setClassicModal1(true)}
                      >
                        アカウント発行
                      </Button1>
                    </GridItem>
                  </GridContainer>  
                )}
                )}
              </DialogContent>
            </Dialog>

            <Dialog
              classes={{
                root: classes.center + " " + classes.modalRoot,
                paper: classes.modal
              }}
              open={deleteProjectModal}
              TransitionComponent={Transition}
              keepMounted
              onClose={() => setDeleteProjectModal(false)}
              aria-labelledby="classic-modal-slide-title"
              aria-describedby="classic-modal-slide-description"
            >
              <DialogTitle
                id="classic-modal-slide-title"
                disableTypography
                className={classes.modalHeader}
              >
                <h4><b>本当に削除しますか？</b></h4>
              </DialogTitle>
              <DialogActions
                className={
                  classes.modalFooter + " " + classes.modalFooterCenter
                }
              >
                <Button
                  onClick={() => setDeleteProjectModal(false)}
                  color="transparent"
                  className={classes.modalSmallFooterFirstButton}
                >
                  キャンセル
                </Button>
                <Button
                  // onClick={() => setDeleteProjectModal(false)}
                  color="danger"
                  simple
                  className={
                    classes.modalSmallFooterFirstButton +
                    " " +
                    classes.modalSmallFooterSecondButton
                  }
                >
                  削除する
                </Button>
              </DialogActions>            
            </Dialog>
                  
            <Card>
                <CardBody>
                    {user.roles[0].id == 3 && 
                        <Table
                            className={ classes.fontSize }
                            tableHeaderColor="primary"
                            tableHead={["No", "案件名", "発注日", "目安納品日", "ステータス"]}
                            tableData={projectsTableData}
                            coloredColls={[4]}
                            colorsColls={["primary"]}
                        />
                    }
                    {user.roles[0].id == 2 && 
                         <Table
                            className={ classes.fontSize }
                            tableHeaderColor="primary"
                            tableHead={["No", "案件名", "発注金額", "発注日", "目安納品日", "発注請書", "請求書", "ステータス"]}
                            tableData={projectsTableData}
                            coloredColls={[7]}
                            colorsColls={["primary"]}
                       />
                    }
                    {user.roles[0].id == 1 && 
                         <Table
                            className={ classes.fontSize }
                            tableHeaderColor="primary"
                            tableHead={["No", "案件名", "発注企業", "発注金額", "発注日", "目安納品日", "ステータス", "割当", "削除"]}
                            tableData={projectsTableData}
                            coloredColls={[6]}
                            colorsColls={["primary"]}
                       />
                    }
                </CardBody>
            </Card>
        </div>
    );
}


const mapStateToProps = (state, ownProps) => ({
    user: state.auth.user
})
  
const mapDispatchToProps = ({})
  
export default connect(mapStateToProps, mapDispatchToProps)(withRouter(ProjectList))