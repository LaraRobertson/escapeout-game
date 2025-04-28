import { createPortal } from "react-dom";
import Modal from "react-modal";
import React from "react";
import { Button } from "@wordpress/components";
import "../../assets/modal-v1.css";

export function ReactModalFromRight({ modalContent, setModalContent, children }) {
    console.log("ReactModalFromRight");
    Modal.setAppElement("#wpbody");
    function closeModal() {
        setModalContent({ open: false, content: "" });
    }

    return (
        <>
            {createPortal(
                <Modal
                    closeTimeoutMS={200}
                    isOpen={modalContent?.open}
                    onRequestClose={closeModal}
                    className="modalContent adminModal"
                    contentLabel="General"
                    overlayClassName="slide-from-right"
                    parentSelector={() => document.querySelector("#wpbody")}
                    preventScroll={false}
                >
                    <div className="modal-top-bar">
                        <header className="modal_header">
                            <div><strong> {modalContent?.content}</strong>
                            </div>
                        </header>
                        <Button className="close-button-modal light" onClick={closeModal}>
                            X
                        </Button>
                    </div>

                    {children}

                    <div className="modal-from-top-close" style={{ textAlign: "center", width: "100%" }}>
                        <Button className="close light" onClick={closeModal}>
                            close
                        </Button>
                    </div>
                </Modal>,
                document.getElementById("wpbody")
            )}
        </>
    );
}
