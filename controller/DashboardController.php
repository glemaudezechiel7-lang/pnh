<?php
/** Package controller */
class DashboardController
{
    public function afficher(): void
    {
        requireAuth();

        $agentDAO = new AgentDAO();
        $plainteDAO = new PlainteDAO();
        $gardeDAO = new GardeAVueDAO();
        $rapportDAO = new RapportInterventionDAO();
        $commissariatDAO = new CommissariatDAO();

        $stats = [
            'agents_total' => $agentDAO->countTotal(),
            'agents_en_service' => $agentDAO->countByStatut('en_service'),
            'plaintes_ouvertes' => $plainteDAO->countByStatut('ouverte') + $plainteDAO->countByStatut('en_cours'),
            'gardes_en_cours' => $gardeDAO->countEnCours(),
            'operations_du_mois' => $rapportDAO->countCeMois(),
            'commissariats_total' => count($commissariatDAO->findAll()),
        ];

        $dernieresPlaintes = array_slice($plainteDAO->findAll(), 0, 5);
        $dernieresGardes = array_slice($gardeDAO->findAll(), 0, 5);
        $derniersRapports = array_slice($rapportDAO->findAll(), 0, 5);

        require __DIR__ . '/../vue/dashboard.php';
    }
}
