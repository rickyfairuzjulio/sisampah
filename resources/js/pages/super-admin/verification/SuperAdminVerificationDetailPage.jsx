import React, { useState } from 'react';
import AdminAppLayout from '@/layouts/AdminAppLayout';
import WorkstationHeader from './sections/WorkstationHeader';
import UnitProfileCard from './sections/UnitProfileCard';
import DocumentAuditCard from './sections/DocumentAuditCard';
import VerificationPipelineSidebar from './sections/VerificationPipelineSidebar';
import ScheduleMeetingModal from './sections/ScheduleMeetingModal';
import RecordMeetingResultModal from './sections/RecordMeetingResultModal';
import ApproveUnitModal from './sections/ApproveUnitModal';
import RejectUnitModal from './sections/RejectUnitModal';

export default function SuperAdminVerificationDetailPage({
    authData = {},
    bankSampah = {},
    documents = [],
    verifications = [],
    csrfToken = '',
}) {
    const [docsState, setDocsState] = useState(documents);
    const [verifsState, setVerifsState] = useState(verifications);
    const [unitState, setUnitState] = useState(bankSampah);

    // Modal state controllers
    const [isScheduleOpen, setIsScheduleOpen] = useState(false);
    const [isRecordResultOpen, setIsRecordResultOpen] = useState(false);
    const [isApproveOpen, setIsApproveOpen] = useState(false);
    const [isRejectOpen, setIsRejectOpen] = useState(false);

    // Handlers
    const handleUpdateDocStatus = (docId, status, catatan) => {
        setDocsState((prev) =>
            prev.map((d) =>
                d.id === docId ? { ...d, status_review: status, catatan } : d
            )
        );

        if (status === 'revision_requested') {
            setUnitState((prev) => ({ ...prev, status_verifikasi: 'document_revision' }));
        }

        // Send async POST request to backend
        fetch(`/super-admin/verifikasi-bank-sampah/${unitState.id}/review-doc/${docId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || '',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                status_review: status,
                catatan: catatan,
            }),
        }).catch((err) => console.log('Update doc status:', err));
    };

    const handleSaveSchedule = ({ method, scheduled_at, notes }) => {
        const newVerif = {
            id: Date.now(),
            method,
            scheduled_at,
            result: 'pending',
            notes,
            verifier_name: auth?.user?.name || 'Super Admin',
            completed_at: null,
        };
        setVerifsState([newVerif, ...verifsState]);
        setUnitState((prev) => ({ ...prev, status_verifikasi: 'meeting_scheduled' }));

        // Send POST request
        fetch(`/super-admin/verifikasi-bank-sampah/${unitState.id}/schedule-meeting`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || '',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                method,
                scheduled_at,
                notes,
            }),
        }).catch((err) => console.log('Schedule meeting:', err));
    };

    const handleSaveResult = ({ result, notes }) => {
        setVerifsState((prev) =>
            prev.map((v, idx) =>
                idx === 0
                    ? {
                          ...v,
                          result,
                          notes,
                          completed_at: new Date().toLocaleDateString('id-ID', {
                              day: 'numeric',
                              month: 'short',
                              year: 'numeric',
                          }),
                      }
                    : v
            )
        );

        // Send POST request
        fetch(`/super-admin/verifikasi-bank-sampah/${unitState.id}/meeting-result`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || '',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                result,
                notes,
            }),
        }).catch((err) => console.log('Meeting result:', err));
    };

    return (
        <AdminAppLayout
            pageTitle={`Audit: ${unitState.nama}`}
            activeMenu="verification"
            authData={authData}
        >
            <div className="space-y-7 pb-16">
                {/* 1. Header Action Bar */}
                <WorkstationHeader
                    bankSampah={unitState}
                    onOpenScheduleModal={() => setIsScheduleOpen(true)}
                    onOpenRecordResultModal={() => setIsRecordResultOpen(true)}
                    onOpenApproveModal={() => setIsApproveOpen(true)}
                    onOpenRejectModal={() => setIsRejectOpen(true)}
                />

                {/* 2. Grid Side-by-Side (8/12 Left, 4/12 Right) */}
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-7 items-start">
                    {/* Left Column (8 cols): Profil & Audit Berkas */}
                    <div className="lg:col-span-8 space-y-7">
                        <UnitProfileCard bankSampah={unitState} />
                        <DocumentAuditCard
                            documents={docsState}
                            bankSampah={unitState}
                            csrfToken={csrfToken}
                            onUpdateDocStatus={handleUpdateDocStatus}
                        />
                    </div>

                    {/* Right Column (4 cols): Pipeline Sidebar */}
                    <div className="lg:col-span-4">
                        <VerificationPipelineSidebar
                            bankSampah={unitState}
                            verifications={verifsState}
                            onOpenScheduleModal={() => setIsScheduleOpen(true)}
                            onOpenRecordResultModal={() => setIsRecordResultOpen(true)}
                        />
                    </div>
                </div>
            </div>

            {/* Modals */}
            <ScheduleMeetingModal
                isOpen={isScheduleOpen}
                onClose={() => setIsScheduleOpen(false)}
                bankSampah={unitState}
                onSaveSchedule={handleSaveSchedule}
            />

            <RecordMeetingResultModal
                isOpen={isRecordResultOpen}
                onClose={() => setIsRecordResultOpen(false)}
                bankSampah={unitState}
                onSaveResult={handleSaveResult}
            />

            <ApproveUnitModal
                isOpen={isApproveOpen}
                onClose={() => setIsApproveOpen(false)}
                bankSampah={unitState}
                csrfToken={csrfToken}
            />

            <RejectUnitModal
                isOpen={isRejectOpen}
                onClose={() => setIsRejectOpen(false)}
                bankSampah={unitState}
                csrfToken={csrfToken}
            />
        </AdminAppLayout>
    );
}
